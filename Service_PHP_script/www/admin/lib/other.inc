<?php

function d($var)
{
	print '<pre style="background: #000; color: #0f0; border: 1px solid #0f0; font: 12px Courier-New;">';
	$ret = print_r($var, true);
	$ret = str_replace('=>', '<font color="#ffffff">=></font>', $ret);
	#$ret = preg_replace('#Array\n\((.*)\n\)#ms', '<div style="border: 1px solid #0f0;">\\0</div>', $ret);
	print $ret;
	print '</pre>';
}

/**
 * Prepare a variable to use in date base
 * Deleting dangerous symbols
 *
 * @param string $variable
 **/
function danger_var($variable)
{
	if (get_magic_quotes_gpc())
	{
		return $variable;
	}

    // array
	if (is_array($variable))
	{
		foreach($variable as $var)
		{
			$var = addslashes($var);
		}
	}

	// variable
	else
	{
		$variable = addslashes($variable);
	}

	return $variable;
}

function get_real_ip()
{
	global $HTTP_ENV_VARS, $HTTP_SERVER_VARS, $REMOTE_ADDR;

	if( getenv('HTTP_X_FORWARDED_FOR') != '' )
	{
		$client_ip = ( !empty($HTTP_SERVER_VARS['REMOTE_ADDR']) ) ? $HTTP_SERVER_VARS['REMOTE_ADDR'] : ( ( !empty($HTTP_ENV_VARS['REMOTE_ADDR']) ) ? $HTTP_ENV_VARS['REMOTE_ADDR'] : $REMOTE_ADDR );

		$entries = explode(',', getenv('HTTP_X_FORWARDED_FOR'));
		reset($entries);
		while (list(, $entry) = each($entries))
		{
			$entry = trim($entry);
			#if ( preg_match("/^([0-9]+\.[0-9]+\.[0-9]+\.[0-9]+)/", $entry, $ip_list) )
			#{
			#	$private_ip = array('/^0\./', '/^127\.0\.0\.1/', '/^192\.168\..*/', '/^172\.((1[6-9])|(2[0-9])|(3[0-1]))\..*/', '/^10\..*/', '/^224\..*/', '/^240\..*/');
			#	$found_ip = preg_replace($private_ip, $client_ip, $ip_list[1]);

			#	if ($client_ip != $found_ip)
			#	{
			#		$client_ip = $found_ip;
			#		break;
			#	}
			#}
		}
	}
	else
	{
		$client_ip = ( !empty($HTTP_SERVER_VARS['REMOTE_ADDR']) ) ? $HTTP_SERVER_VARS['REMOTE_ADDR'] : ( ( !empty($HTTP_ENV_VARS['REMOTE_ADDR']) ) ? $HTTP_ENV_VARS['REMOTE_ADDR'] : $REMOTE_ADDR );
	}
	return $client_ip;
}

function redirect($url)
{
	if(headers_sent())
	{
		print "<meta http-equiv=\"refresh\" content=\"0;url=".$url."\">";
	}
	else
	{
		header('Location: '.$url);
	}
}

// IN: 127.0.0.1
// OUT: 7f000001
function encode_ip($dotquad_ip)
{
	$ip_sep = explode('.', $dotquad_ip);
	return sprintf('%02x%02x%02x%02x', $ip_sep[0], $ip_sep[1], $ip_sep[2], $ip_sep[3]);
}

// IN: 7f000001
// OUT: 127.0.0.1
function decode_ip($encoded_ip)
{
	$ip_sep[0] = substr($encoded_ip, 0, 2);
	$ip_sep[1] = substr($encoded_ip, 2, 2);
	$ip_sep[2] = substr($encoded_ip, 4, 2);
	$ip_sep[3] = substr($encoded_ip, 6, 2);

	return hexdec($ip_sep[0]).'.'.hexdec($ip_sep[1]).'.'.hexdec($ip_sep[2]).'.'.hexdec($ip_sep[3]);
}

function is_empty($str)
{
	if (trim($str) == '') return true;
	else return false;
}

/**
 * Ñמחהאעü הטנועמנט‏, ןמכמזטג םא safe_mode
 *
 * @author baxi
 *
 * @param string $patchname
 * @param oct $mode
 * @param array $ftp
 */
function makedir($patchname, $mode = 0777, $ftp = array())
{
	if (!ini_get('safe_mode'))
	{
		mkdir($patchname, $mode);
	}
	else if (sizeof($ftp) == 3)	// server, login, password
	{
		if ($conn_id = ftp_connect($ftp['server']))
		{
			if (ftp_login($conn_id, $ftp['login'], $ftp['password']))
			{
				$patch = explode('/', $patchname);

				for ($i=0; $i<sizeof($patch); $i++)
				{
					if (!$patch[$i]) continue;

					if (!@ftp_chdir($conn_id, $patch[$i]))
					{
						if (ftp_mkdir($conn_id, $patch[$i]))
						{
							ftp_site($conn_id, 'CHMOD '.decoct($mode).' '.$patch[$i]);

							ftp_chdir($conn_id, $patch[$i]);

						} else {return -4;}	// ERROR: Directory create error
					}
				}
			} else {return -3;}	// ERROR: Login error
		} else {return -2;}	// ERROR: Can't connect
	} else {return -1;} // ERROR: Require array (server => '', login => '', password => '')

	return true;
}

//transliterating
function translit($string, $allow_slashes = 0)
{
	$slash = "";
	if ($allow_slashes) $slash = "\/";

	static $LettersFrom = "אבגדהוחטךכלםמןנסעףפû‎יץ¸";
	static $LettersTo   = "abvgdeziklmnoprstufyejxe";
	static $Consonant = "בגדהזחיךכלםןנסעפץצקרש";
	static $Vowel = "או¸טמףû‎‏ÿ";
	static $BiLetters = array(
	 "ז" => "zh", "צ"=>"ts", "ק" => "ch",
	 "ר" => "sh", "ש" => "sch", "‏" => "ju", "ÿ" => "ja",
	);

	$string = preg_replace("/[_\s\.,?!\[\](){}]+/", "_", $string);
	$string = preg_replace("/-{2,}/", "--", $string);
	$string = preg_replace("/_-+_/", "--", $string);
	$string = preg_replace("/[_\-]+$/", "", $string);

	$string = strtolower( $string );
	//here we replace ת/ü
	$string = preg_replace("/(ü|ת)([".$Vowel."])/", "j\\2", $string);
	$string = preg_replace("/(ü|ת)/", "", $string);
	//transliterating
	$string = strtr($string, $LettersFrom, $LettersTo );
	$string = strtr($string, $BiLetters );

	$string = preg_replace("/j{2,}/", "j", $string);

	$string = preg_replace("/[^".$slash."0-9a-z_\-]+/", "", $string);

	return $string;
}

function log_write($action, $info)
{
	global $user_id;

	switch($action)
	{
		case 'add_post':
		case 'del_post':
		case 'edit_post':
	}
	mysql_query("INSERT INTO `log` (
			`log_id` ,
			`log_user` ,
			`log_time` ,
			`log_action` ,
			`log_info` )
		VALUES (
			'',
			'".$user_id."',
			'".time()."',
			'".$action."',
			'".$info."')");
}

function db_get_columns($table_name)
{
	$res = mysql_query('SELECT * FROM '.$table_name.' LIMIT 0,1');


	$res = mysql_query('SHOW FIELDS FROM '.$table_name);
	while($x = mysql_fetch_assoc($res))
	{
		$type = $x['Type'];
		if(false === strstr($type, '('))
		{
			$type .= '()';
		}
		preg_match('/(.*)\((.*)\)/', $type, $info);
		d($info);

		$ret[$x['Field']] = array(
			'type' => $info[1],
			'size' => ($info[2] ? $info[2] : 0),
			'values' => ($info[1] == 'enum' ? explode(',', $info[2]) : '')
			);
	}
	d($ret);
/*
	$i = 0;
	while ($i < mysql_num_fields($res))
	{
	    $meta = mysql_fetch_field($res, $i);
	    #d($meta);
	    // If there is column and column name IS NOT "item_id"
	    if ($meta && $meta->name != 'item_id')
		{
			$ret[$meta->name] = $meta->type;
	    }
	    $i++;
	}
*/
	// If there is at least one column
	if (isset($ret))
	{
		return $ret;
	}
}


function time_local()
{
	if (defined('TIME_ZONE'))
	{
		return time() + TIME_ZONE * 3600;
	}
	else
	{
		return time();
	}
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

function pgt_microtime() {
	global $microtime, $foother_info;

    list($usec, $sec) = explode(" ", microtime());
    if ($microtime > 0)
    {
    	$now = ((float)$usec + (float)$sec);
		return round($now - $microtime, 3);
    }
    else
    {
    	$microtime = ((float)$usec + (float)$sec);
    }
}

/**
 * Validate email address
 * 
 * @param string $email
 * @return bool
 */
function is_email ($email)
{
	// Hase '@'
	if ($domain = strstr($email, '@'))
	{
		// Hase '.'
		if (strstr($domain, '.'))
		{
			return true;
		}
	}
	 
	return false;
}


?>