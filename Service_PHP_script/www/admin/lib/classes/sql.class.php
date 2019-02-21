<?

class sql
{
	var $host = 'localhost';
	var $login = 'root';
	var $password = '';
	var $db = '';

	var $mysql_functions = array('NOW()', 'UNIX_TIMESTAMP()');
	
	var $error = false;
	var $error_str = '';		// Description of error

	var $debug = false;			// Debug mode: true - show sql query
	var $statistic = array();	// Statistic of used queryes
								// $statistic['insert'] - count of 'insert' queryes used
								// $statistic['select'] - count of 'select' queryes used
								// $statistic['all'] - count of all queryes used, etc...

	function connect($host='', $login='', $password='', $db='')
	{
		if (!$host) $host = $this->host;
		if (!$login) $login = $this->login;
		if (!$password) $password = $this->password;
		if (!$db) $db = $this->db;

        // Count of queryes
        $this->statistic['insert'] = 0;
        $this->statistic['select'] = 0;
        $this->statistic['update'] = 0;
        $this->statistic['delete'] = 0;
        $this->statistic['all'] = 0;

        @mysql_connect($host, $login, $password);
		@mysql_select_db($db);

        if (mysql_errno() != 0)
        {
        	$this->set_error(mysql_error());
        	return 0;
        }
        return 1;
	}

    // SELECT
    // array select(string table, string columns, mixed expressions)
	function select($table, $columns = '*', $expressions = '1', $misc='')
	{
		if (trim($table) == '') $this->set_error('You must specify a table name');

		// @todo Add support of SQL_PREF
		$sql = "SELECT ".$columns." FROM `".$table."` WHERE ";
		if (is_array($expressions))
		{
			foreach ($expressions as $k => $v) $vars[] = "`".$k."` = '".danger_var($v)."'";
			$expressions = implode(" and ", $vars);
		}
		$sql .= $expressions;
		$sql .= ' '.$misc;	// order, group, etc...

		if($this->debug)
		{
			$this->print_sql($sql);	
		}

		$result = mysql_query($sql);
		if ($result)
		{
			$num_rows = mysql_num_rows($result);
			if ($num_rows == 0)	return 0;
			else
			{
				for ($i = 0; $i <  mysql_num_rows($result); $i++)
					$ret_values[] = mysql_fetch_array($result, MYSQL_ASSOC);
				return $ret_values;
			}
		}
		else	// !$result
		{
			$this->set_error('Ivalid query');
			return 0;
		}
	}

    // INSERT
    // int insert(string table, array expressions)
	//
    // Note that if the function returns 0 it's not error.
	function insert($table, $expressions)
	{
		if (trim($table) == '') $this->set_error('You must specify a table name');

        $sql = "INSERT INTO `".$table."`";
        foreach ($expressions as $k => $v)
        {
        	$keys[] = "`".$k."`";
        	
        	// Don't touch MySQL functions
        	if(in_array($v, $this->mysql_functions))
        	{
        		$values[] = $v;
        	}
        	else
			{
        		$values[] = "'".danger_var($v)."'";
			}
        }
        $sql .= " (".implode(",", $keys).") VALUES (".implode(",", $values).")";

		if($this->debug)
		{
			$this->print_sql($sql);	
		}

        $result = mysql_query($sql);
		if (!$result) $this->set_error('Ivalid query');
		return mysql_insert_id();
	}

    // UPDATE
    // int update(string table, mixed expressions, mixed matches)
	function update($table, $expressions, $matches)
	{
		$sql = "UPDATE `".$table."` SET ";

		// SET ...
		if (is_array($expressions))
		{
	        foreach ($expressions as $ek => $ev)
	        {
	        	// Don't touch MySQL functions
	        	if(in_array($ev, $this->mysql_functions))
	        	{
		            $expr[] = "`".$ek."` = ".$ev."";
	        	}
	        	else
	        	{
		            $expr[] = "`".$ek."` = '".danger_var($ev)."'";
	        	}
	        }
			$expr = implode(",", $expr);
		}
		else $expr = $expressions;

        // WHERE .....
		if (is_array($matches))
		{
	        foreach ($matches as $mk => $mv)
	        {
	            $match[] = "`".$mk."` = '".danger_var($mv)."'";
	        }
			$match = implode(" AND ", $match);
		}
		else $match = $matches;

        $sql .= $expr." WHERE ".$match;

		if($this->debug)
		{
			$this->print_sql($sql);	
		}

        $result = mysql_query($sql);
		if (!$result) $this->set_error('Ivalid query');

		return mysql_affected_rows();	// count of affected rows
	}

    // DELETE
    // int delete(string table, mixed expressions)
	function delete($table, $expressions)
	{
		$sql = "DELETE FROM `".$table."` WHERE ";

        if (!@$expressions or @trim($expressions) == "") return 0;
        // WHERE .....
		if (is_array($expressions))
		{
	        foreach ($expressions as $k => $v)
	        {
	            $expr[] = "`".$k."` = '".danger_var($v)."'";
	        }
			$expr = implode(" AND ", $expr);
		}
		else $expr = $expressions;

		$sql .= $expr;
		#print $sql;

        $result = mysql_query($sql);
		if (!$result) $this->set_error('Ivalid query');

		return mysql_affected_rows();	// count of affected rows
	}

	// QUERY
	function query($query)
	{
		if($this->debug)
		{
			$this->print_sql($query);	
		}
		
		$ret = mysql_query($query); 
		if($ret)
		{
			return $ret;	
		}	
		else
		{
			print "<font color=red>".mysql_error()."</font>";
		}
	}

    function set_error($error_str)
    {
		$this->error = true;
		$this->error_str = $error_str;
		return 0;
    }
    
	function print_sql($string)
	{
		$string = preg_replace('#[0-9]+#i', "<font color=#ff0000>\\0</font>", $string);
		$string = preg_replace('#[a-zA-Z]+\.#i', "<font color=#0000f0><b>\\0</b></font>", $string);
		$string = preg_replace('#(select|update|delete|insert|from|where|order|limit)#i', "\n<font color=#ff6600>\\0</font>\n\t", $string);
		$string = preg_replace('#( AS )#i', "<font color=#808000><b>\\0</b></font>", $string);
		$string = preg_replace('#( AND | OR )#i', "\n\t<font color=#008000><b>\\0</b></font>", $string);
		$string = preg_replace('#\'(.*)\'#i', "<font color=#0000f0>\\0</font>", $string);
	
		print "<pre style='background: #eee; border: 1px black solid; margin: 20px; padding: 5px;'>".$string."</pre>";
	}
}

?>