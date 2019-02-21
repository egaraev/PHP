<?php
include('columns/columns.php');
include('config.inc.php');
include('lib/other.inc');
include('lib/classes/sql.class.php');

$db = new sql;
$db->host     = SQL_HOST;
$db->login    = SQL_LOGIN;
$db->password = SQL_PASSWORD;
$db->db       = SQL_DB;
$db->connect();


?>
<title>Admin panel</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<style>
body, table {margin: 0px; font: 11px Verdana}
ul a {color: #000}
.data {background: #aaa;}
.data td {background: #fff; padding: 4px}
</style>
<script language="javascript" src="wf2/wf2.js"></script>

<h3 align="center" style="background: #cce; color: #000; border-bottom: 1px solid gray">Admin panel </h3>
<table border=0 width=100% height=90%>
<tr><td width=200 align=left valign=top style="background: #cec; color: #000; border: 1px solid #000;">
<ul>
<li><a href="?module=articles">Статьи</a>
<li><a href="?module=authors">Авторы</a>
<li><a href="?module=categories">Категории</a>
<li><a href="?module=dictionary">Словарь</a>
<li><a href="?module=news">Новости</a>
<li><a href="?module=releases">Выпуски</a>
<li><a href="?module=users">Пользователи</a>
</ul>
</td>

<td align=left valign=top style="background: #fff; color: #000; border: 1px solid #000; padding-left: 10px; padding-top: 10px;">
<?php

$module = (isset($_GET['module']) 
		? $_GET['module'] 
		: (isset($_POST['module']) 
			? $_POST['module'] 
			: ''));
$module = str_replace(array('.', '/', '\\', '\''), '', $module);

$action = (isset($_GET['action']) 
		? $_GET['action'] 
		: (isset($_POST['action']) 
			? $_POST['action'] 
			: ''));
			
$action = str_replace(array('.', '/', '\\', '\''), '', $action);

switch ($action)
{
	case 'delete':
		if (@is_numeric(@$_GET['id']))
		{
			if (isset($_keys[$module]))
			{
				$db->delete($module, array($_keys[$module] => $_GET['id']));
				redirect('?module='.$module);
			}
		}
		break;

	case 'edit':
	case 'add':
		if (@$_POST['step'] == 2) // Add information to DB or Edit
		{
			foreach ($_columns[$module] as $field_name => $field_description)
			{
				$data[$field_name] = $_POST[$field_name];
			}
			
			// EDIT
			if ($action == 'edit')
			{
				$db->update($module, $data, array($_keys[$module] => $_POST['id']));
			} 
			// ADD
			else if ($action == 'add')
			{
				$db->insert($module, $data);
			}
			
			if ($db->error)
			{
				print "<font color=red>Ошибка: </font> ".$db->error_str;
			}
			else
			{
				print "Добавлено";
				redirect('?module='.$module);
				#d($_POST);
			}
		}
		else
		{
			// Show form
			include('forms/forms.inc.php');
			print '<form action="index.php" method="post">';
			print '<input type="hidden" name="step" value="2">';
			print '<input type="hidden" name="action" value="'.$action.'">';
			print '<input type="hidden" name="module" value="'.$module.'">';
			if (isset($_GET['id']))
			{
				print '<input type="hidden" name="id" value="'.$_GET['id'].'">';	
			}
			print '<table>';
			
			if ($action == 'edit')
			{
				$rows = $db->select($module, '*', array($_keys[$module] => $_GET['id']));
				$values = $rows[0];
			}
			else
			{
				// Default value
				$values = isset($form_defaults[$module])
					?  $form_defaults[$module]
					: '';
			}
			
			foreach ($form[$module] as $field_name => $field_type)
			{
				print '<tr><td valign=top>'.$_columns[$module][$field_name].'</td><td valign=top>';
				
				switch ($field_type)
				{
					case 'text':
						print '<input type="text" name="'.$field_name.'" value="'.htmlspecialchars(@$values[$field_name]).'" size=50 required>';
						break;

					case 'int':
						print '<input type="number" name="'.$field_name.'" value="'.htmlspecialchars(@$values[$field_name]).'" size=50>';
						break;

					case 'date':
						print '<input type="date" name="'.$field_name.'" value="'.htmlspecialchars(@$values[$field_name]).'" size=50>';		// value="2004-08-31"
						break;

					case 'datetime':
						print '<input type="datetime-local" name="'.$field_name.'" value="'.htmlspecialchars(@$values[$field_name]).'" size=50>';	// value="2004-08-31T10:22"
						break;
						
					case 'textarea':
						print '<textarea name="'.$field_name.'" rows="30" cols="100">'.htmlspecialchars(@$values[$field_name]).'</textarea>';
						break;

					case 'textarea_reach':
						?>
						<!-- TinyMCE -->
						<script language="javascript" type="text/javascript" src="tiny_mce.js"></script>
						<script language="javascript" type="text/javascript">
							tinyMCE.init({
								mode : "textareas",
								theme : "advanced",
								plugins : "table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,zoom,flash,searchreplace,print,paste,directionality,fullscreen,noneditable,contextmenu",
								theme_advanced_buttons1_add_before : "save,newdocument,separator",
								theme_advanced_buttons1_add : "fontselect,fontsizeselect",
								theme_advanced_buttons2_add : "separator,insertdate,inserttime,preview,zoom,separator,forecolor,backcolor,liststyle",
								theme_advanced_buttons2_add_before: "cut,copy,paste,pastetext,pasteword,separator,search,replace,separator",
								theme_advanced_buttons3_add_before : "tablecontrols,separator",
								theme_advanced_buttons3_add : "emotions,iespell,flash,advhr,separator,print,separator,ltr,rtl,separator,fullscreen",
								theme_advanced_toolbar_location : "top",
								theme_advanced_toolbar_align : "left",
								theme_advanced_statusbar_location : "bottom",
								plugin_insertdate_dateFormat : "%Y-%m-%d",
								plugin_insertdate_timeFormat : "%H:%M:%S",
								extended_valid_elements : "hr[class|width|size|noshade]",
								file_browser_callback : "fileBrowserCallBack",
								paste_use_dialog : false,
								theme_advanced_resizing : true,
								theme_advanced_resize_horizontal : false,
								theme_advanced_link_targets : "_something=My somthing;_something2=My somthing2;_something3=My somthing3;",
								apply_source_formatting : true
							});
						
							function fileBrowserCallBack(field_name, url, type, win) {
								var connector = "../../filemanager/browser.html?Connector=connectors/php/connector.php";
								var enableAutoTypeSelection = true;
								
								var cType;
								tinyfck_field = field_name;
								tinyfck = win;
								
								switch (type) {
									case "image":
										cType = "Image";
										break;
									case "flash":
										cType = "Flash";
										break;
									case "file":
										cType = "File";
										break;
								}
								
								if (enableAutoTypeSelection && cType) {
									connector += "&Type=" + cType;
								}
								
								window.open(connector, "tinyfck", "modal,width=600,height=400");
							}
						</script>
						<!-- /TinyMCE -->
						<?php
						print '<textarea name="'.$field_name.'" rows="30" cols="100">'.htmlspecialchars(@$values[$field_name]).'</textarea>';
						break;
					
					case 'dropdown':
						print '<select name="'.$field_name.'">';

						$res = mysql_query('SELECT * FROM '.$form_elements[$module][$field_name]['source_table']);
						while ($element = mysql_fetch_assoc($res))
						{
							$key   = $element[$form_elements[$module][$field_name]['key']];
							$value = $element[$form_elements[$module][$field_name]['value']];
							#print $values[$field_name];							
							#print $key;
							print '<option '.($values[$field_name] == $key ? 'selected' : '').' value="'.$element[$form_elements[$module][$field_name]['key']].'">'.$element[$form_elements[$module][$field_name]['value']].'</option>';
						}
						print '</select>';
						break;
				}
			}
			
			print '<tr><td></td><td><input type="submit" value="Добавить"></td></tr>';
			print '</table>';			
			print '</form>';
		}
		break;
		
		
	default:
		if (isset($_columns[$module]))
		{
			print "<h2>".$module."</h2>";
			print "<a href=?module=$module&action=add><b>Новая запись</b></a><br><br>";
			
			print '<table border=0 class="data" cellspacing=1><tr><td style="background: #ddd">&nbsp;</td><td style="background: #ddd">&nbsp;</td>';
			foreach ($_columns[$module] as $col_name => $col_title)
			{
				print '<td style="background: #ddd">'.$col_title.'</td>';
				
				$select_cols[] = $col_name;
			}
			print '</tr>';
			
			$rows = $db->select($module, implode(',', $select_cols ));
			
			if ($rows)
			{
				foreach ($rows as $row)
				{
					
					print '<tr><td style="background: #ddd"><a href="?module='.$module.'&action=edit&id='.$row[$_keys[$module]].'">Изменить</a></td><td style="background: #ddd"><a href="?module='.$module.'&action=delete&id='.$row[$_keys[$module]].'" onclick="return confirm(\'Удалить?\');"><font color=red>X</font></a></td>';
						foreach ($row as $col)
						{
							print "<td>";
								if (strlen($col) > 50 )
								{
									$col = substr($col, 0, 50);
									$col = str_replace(array('\n', '\t', '\r'), '', $col);
									$col .= '...';
								}
								print $col;
							print "</td>";
						}
					print '</tr>';
				}
			}
			?>
</table>
		<?php
		}
		break;
}
		
?>
</td>
</tr>
</table>