<?php
	$link=mysql_connect('localhost','root','');
	mysql_select_db('ipacc');
	$ip=mysql_real_escape_string($_GET['ip']);
	$day=mysql_real_escape_string($_GET['day']);
	$month=mysql_real_escape_string($_GET['month']);
	$year=mysql_real_escape_string($_GET['year']);
	//$day=mysql_real_escape_string($_GET['day']);

///////////////////////////////////////////////////////////////////	
	$querys_tcp_21		="SELECT sum(bytes)  FROM `new` WHERE `src_ip` =  '$ip' AND `dst_port` =21  and day=$day and month=$month and year=$year group by `src_ip`";
	$querys_tcp_22		="SELECT sum(bytes)  FROM `new` WHERE `src_ip` =  '$ip' AND `dst_port` =22  and day=$day and month=$month and year=$year group by `src_ip`";
	$querys_tcp_23		="SELECT sum(bytes)  FROM `new` WHERE `src_ip` =  '$ip' AND `dst_port` =23  and day=$day and month=$month and year=$year group by `src_ip`";
	$querys_tcp_25		="SELECT sum(bytes)  FROM `new` WHERE `src_ip` =  '$ip' AND `dst_port` =25  and day=$day and month=$month and year=$year group by `src_ip`";
	$querys_tcp_80		="SELECT sum(bytes)  FROM `new` WHERE `src_ip` =  '$ip' AND `dst_port` =80  and day=$day and month=$month and year=$year group by `src_ip`";
	$querys_tcp_110		="SELECT sum(bytes)  FROM `new` WHERE `src_ip` =  '$ip' AND `dst_port` =110 and day=$day and month=$month and year=$year group by `src_ip`";
	$querys_tcp_143		="SELECT sum(bytes)  FROM `new` WHERE `src_ip` =  '$ip' AND `dst_port` =143 and day=$day and month=$month and year=$year group by `src_ip`";
	$querys_tcp_443		="SELECT sum(bytes)  FROM `new` WHERE `src_ip` =  '$ip' AND `dst_port` =443 and day=$day and month=$month and year=$year group by `src_ip`";
	$querys_tcp_993		="SELECT sum(bytes)  FROM `new` WHERE `src_ip` =  '$ip' AND `dst_port` =993 and day=$day and month=$month and year=$year group by `src_ip`";

	$queryr_tcp_21		="SELECT sum(bytes)  FROM `new` WHERE `dst_ip` =  '$ip' AND `src_port` =21  and day=$day and month=$month and year=$year group by `dst_ip`";
	$queryr_tcp_22		="SELECT sum(bytes)  FROM `new` WHERE `dst_ip` =  '$ip' AND `src_port` =22  and day=$day and month=$month and year=$year group by `dst_ip`";
	$queryr_tcp_23		="SELECT sum(bytes)  FROM `new` WHERE `dst_ip` =  '$ip' AND `src_port` =23  and day=$day and month=$month and year=$year group by `dst_ip`";
	$queryr_tcp_25		="SELECT sum(bytes)  FROM `new` WHERE `dst_ip` =  '$ip' AND `src_port` =25  and day=$day and month=$month and year=$year group by `dst_ip`";
	$queryr_tcp_80		="SELECT sum(bytes)  FROM `new` WHERE `dst_ip` =  '$ip' AND `src_port` =80  and day=$day and month=$month and year=$year group by `dst_ip`";
	$queryr_tcp_110		="SELECT sum(bytes)  FROM `new` WHERE `dst_ip` =  '$ip' AND `src_port` =110 and day=$day and month=$month and year=$year group by `dst_ip`";
	$queryr_tcp_143		="SELECT sum(bytes)  FROM `new` WHERE `dst_ip` =  '$ip' AND `src_port` =143 and day=$day and month=$month and year=$year group by `dst_ip`";
	$queryr_tcp_443		="SELECT sum(bytes)  FROM `new` WHERE `dst_ip` =  '$ip' AND `src_port` =443 and day=$day and month=$month and year=$year group by `dst_ip`";
	$queryr_tcp_993		="SELECT sum(bytes)  FROM `new` WHERE `dst_ip` =  '$ip' AND `src_port` =993 and day=$day and month=$month and year=$year group by `dst_ip`";

	$querys_udp_53		="SELECT sum(bytes)  FROM `new` WHERE `src_ip` =  '$ip' AND `dst_port` =53  and day=$day and month=$month and year=$year group by `src_ip`";
	
	$queryr_udp_53		="SELECT sum(bytes)  FROM `new` WHERE `dst_ip` =  '$ip' AND `src_port` =53  and day=$day and month=$month and year=$year group by `dst_ip`";
	

	$querys_other_5190	="SELECT sum(bytes)  FROM `new` WHERE `src_ip` =  '$ip' AND `dst_port` =5190 and day=$day and month=$month and year=$year group by `src_ip`";
	
	$queryr_other_5190	="SELECT sum(bytes)  FROM `new` WHERE `dst_ip` =  '$ip' AND `src_port` =5190 and day=$day and month=$month and year=$year group by `dst_ip`";
	
	//////////////////////////////////////////////////////////////////////

	$querys_top5_tcp="SELECT src_ip, dst_port, SUM(bytes) AS TEST FROM `new`  WHERE `src_ip` = '$ip' and day=$day and month=$month and year=$year AND proto =6 group by dst_port  ORDER BY TEST DESC LIMIT 0 , 10 ";
	$queryr_top5_tcp="SELECT dst_ip, src_port, SUM(bytes) AS TEST FROM `new`  WHERE `dst_ip` = '$ip' and day=$day and month=$month and year=$year AND proto =6 group by src_port ORDER BY TEST DESC LIMIT 0 , 10 ";

	$querys_top5_udp="SELECT src_ip, dst_port, SUM(bytes) AS TEST FROM `new`  WHERE `src_ip` = '$ip' and day=$day and month=$month and year=$year AND proto =17 group by dst_port ORDER BY TEST DESC LIMIT 0 , 10 ";
	$queryr_top5_udp="SELECT dst_ip, src_port, SUM(bytes) AS TEST FROM `new`  WHERE `dst_ip` = '$ip' and day=$day and month=$month and year=$year AND proto =17 group by src_port ORDER BY TEST DESC LIMIT 0 , 10 ";

//////////////////////////////////////////////////////////////////////
	$res_s_tcp_21=mysql_query($querys_tcp_21);
	$res_s_tcp_22=mysql_query($querys_tcp_22);
	$res_s_tcp_23=mysql_query($querys_tcp_23);
	$res_s_tcp_25=mysql_query($querys_tcp_25);
	$res_s_tcp_80=mysql_query($querys_tcp_80);
	$res_s_tcp_110=mysql_query($querys_tcp_110);
	$res_s_tcp_143=mysql_query($querys_tcp_143);
	$res_s_tcp_443=mysql_query($querys_tcp_443);
	$res_s_tcp_993=mysql_query($querys_tcp_993);
	
	$res_r_tcp_21=mysql_query($queryr_tcp_21);
	$res_r_tcp_22=mysql_query($queryr_tcp_22);
	$res_r_tcp_23=mysql_query($queryr_tcp_23);
	$res_r_tcp_25=mysql_query($queryr_tcp_25);
	$res_r_tcp_80=mysql_query($queryr_tcp_80);
	$res_r_tcp_110=mysql_query($queryr_tcp_110);
	$res_r_tcp_143=mysql_query($queryr_tcp_143);
	$res_r_tcp_443=mysql_query($queryr_tcp_443);
	$res_r_tcp_993=mysql_query($queryr_tcp_993);
	
	
	$res_s_udp_53=mysql_query($querys_udp_53);
	
	$res_r_udp_53=mysql_query($queryr_udp_53);
	
	
	$res_s_other_5190=mysql_query($querys_other_5190);

	
	$res_r_other_5190=mysql_query($queryr_other_5190);
	
////////////////////////////////////////////////////////
	$res_s_top5_tcp=mysql_query($querys_top5_tcp);
	$res_r_top5_tcp=mysql_query($queryr_top5_tcp);
	
	$res_s_top5_udp=mysql_query($querys_top5_udp);
	$res_r_top5_udp=mysql_query($queryr_top5_udp);
////////////////////////////////////////////////////////	
////////////////////////////////////////////////////////////////////


	$row_s_tcp_21=mysql_fetch_array($res_s_tcp_21);
	$row_s_tcp_22=mysql_fetch_array($res_s_tcp_22);
	$row_s_tcp_23=mysql_fetch_array($res_s_tcp_23);
	$row_s_tcp_25=mysql_fetch_array($res_s_tcp_25);
	$row_s_tcp_80=mysql_fetch_array($res_s_tcp_80);
	$row_s_tcp_110=mysql_fetch_array($res_s_tcp_110);
	$row_s_tcp_143=mysql_fetch_array($res_s_tcp_143);
	$row_s_tcp_443=mysql_fetch_array($res_s_tcp_443);
	$row_s_tcp_993=mysql_fetch_array($res_s_tcp_993);
	
	$row_r_tcp_21=mysql_fetch_array($res_r_tcp_21);
	$row_r_tcp_22=mysql_fetch_array($res_r_tcp_22);
	$row_r_tcp_23=mysql_fetch_array($res_r_tcp_23);
	$row_r_tcp_25=mysql_fetch_array($res_r_tcp_25);
	$row_r_tcp_80=mysql_fetch_array($res_r_tcp_80);
	$row_r_tcp_110=mysql_fetch_array($res_r_tcp_110);
	$row_r_tcp_143=mysql_fetch_array($res_r_tcp_143);
	$row_r_tcp_443=mysql_fetch_array($res_r_tcp_443);
	$row_r_tcp_993=mysql_fetch_array($res_r_tcp_993);
	
	
	$row_s_udp_53=mysql_fetch_array($res_s_udp_53);
	
	$row_r_udp_53=mysql_fetch_array($res_r_udp_53);
	
	$row_s_other_5190=mysql_fetch_array($res_s_other_5190);

	$row_r_other_5190=mysql_fetch_array($res_r_other_5190);
/////////////////////////////////////////////////////////////////////

	
?>
<style type="text/css">
<!--
.style1 {
	color: #000099;
	font-weight: bold;
}
-->
</style>


<table width="100%" border="1" cellpadding="3" cellspacing="3" bordercolor="#000000" bgcolor="#ff0000">
  <tr>
    <td bgcolor="#ffcc33"><div align="center" class="style1">IP</div></td>
    <td bgcolor="#ffcc33"><div align="center" class="style1">TCP 21 <br /> 
    ftp </div></td>
    <td bgcolor="#ffcc33"><div align="center" class="style1">TCP 22<br /> 
    SSH </div></td>
    <td bgcolor="#ffcc33"><div align="center" class="style1">TCP 23 <br />
    telnet</div></td>
    <td bgcolor="#ffcc33"><div align="center" class="style1">TCP 25<br /> 
    smtp</div></td>
    <td bgcolor="#ffcc33"><div align="center" class="style1">TCP 80<br /> 
    http</div></td>
    <td bgcolor="#ffcc33"><div align="center" class="style1">TCP 110<br /> 
    pop3</div></td>
    <td bgcolor="#ffcc33"><div align="center" class="style1">TCP 143<br /> 
    imap</div></td>
    <td bgcolor="#ffcc33"><div align="center" class="style1">TCP 443<br /> 
    https</div></td>
    <td bgcolor="#ffcc33"><div align="center" class="style1">TCP 993<br /> 
    pop3S and IMAP SSL</div></td>
    <td bgcolor="#ffcc33"><div align="center" class="style1">UDP 53<br /> 
    dns</div></td>
    
    <td bgcolor="#ffcc33"><div align="center" class="style1">TCP 5190<br /> 
    ICQ </div></td>
  </tr>
  <tr>
    <td bgcolor="#00CCFF" class="style1"><?echo $ip?></td>
    <td bgcolor="#00CCFF" class="style1"><? printf("%0.2f", ($row_s_tcp_21[0]/(1024*1024)));?>&nbsp;/&nbsp;<? printf("%0.2f", ( $row_r_tcp_21[0]/(1024*1024)))?></td>
    <td bgcolor="#00CCFF" class="style1"><? printf("%0.2f", ($row_s_tcp_22[0]/(1024*1024)));?>&nbsp;/&nbsp;<? printf("%0.2f", ( $row_r_tcp_22[0]/(1024*1024)));?></td>
    <td bgcolor="#00CCFF" class="style1"><? printf("%0.2f", ($row_s_tcp_23[0]/(1024*1024)));?>&nbsp;/&nbsp;<? printf("%0.2f", ( $row_r_tcp_23[0]/(1024*1024)));?></td>
    <td bgcolor="#00CCFF" class="style1"><? printf("%0.2f", ($row_s_tcp_25[0]/(1024*1024)));?>&nbsp;/&nbsp;<? printf("%0.2f", ( $row_r_tcp_25[0]/(1024*1024)));?></td>
    <td bgcolor="#00CCFF" class="style1"><? printf("%0.2f", ($row_s_tcp_80[0]/(1024*1024)));?>&nbsp;/&nbsp;<? printf("%0.2f", ( $row_r_tcp_80[0]/(1024*1024)));?>&nbsp;</td>
    <td bgcolor="#00CCFF" class="style1"><? printf("%0.2f", ($row_s_tcp_110[0]/(1024*1024)));?>&nbsp;/&nbsp;<? printf("%0.2f", ( $row_r_tcp_110[0]/(1024*1024)));?>&nbsp;</td>
    <td bgcolor="#00CCFF" class="style1"><? printf("%0.2f", ($row_s_tcp_143[0]/(1024*1024)));?>&nbsp;/&nbsp;<? printf("%0.2f", ( $row_r_tcp_143[0]/(1024*1024)));?>&nbsp;</td>
    <td bgcolor="#00CCFF" class="style1"><? printf("%0.2f", ($row_s_tcp_443[0]/(1024*1024)));?>&nbsp;/&nbsp;<? printf("%0.2f", ( $row_r_tcp_443[0]/(1024*1024)));?>&nbsp;</td>
    <td bgcolor="#00CCFF" class="style1"><? printf("%0.2f", ($row_s_tcp_993[0]/(1024*1024)));?>&nbsp;/&nbsp;<? printf("%0.2f", ( $row_r_tcp_993[0]/(1024*1024)));?>&nbsp;</td>
    <td bgcolor="#00CCFF" class="style1"><? printf("%0.2f", ($row_s_udp_53[0]/(1024*1024)));?>&nbsp;/&nbsp;<? printf("%0.2f", ( $row_r_udp_53[0]/(1024*1024)));?>&nbsp;</td>
    <td bgcolor="#00CCFF" class="style1"><? printf("%0.2f", ($row_s_other_5190[0]/(1024*1024)));?>&nbsp;/&nbsp;<? printf("%0.2f", ( $row_r_other_5190[0]/(1024*1024)));?>&nbsp;</td>
  </tr>
</table>
<br />
<table cellspacing="5" cellpadding="5">
<tr valign="top"><td>
<table border="1" cellpadding="0" cellspacing="3" bordercolor="#000000" bgcolor="ff0000">
	<tr>
		<td colspan="3" align="center" bgcolor="#ff9933" class="style1"> TCP SENDING</td>
	</tr>
	<tr>
		<td bgcolor="#ffcc33" class="style1">Port</td>
		<td bgcolor="#ffcc33" class="style1">MBytes</td>
	</tr>
		<? while ($row_s_top5_tcp=mysql_fetch_array($res_s_top5_tcp)) {?>
	<tr>
		<td bgcolor="#00CCFF" class="style1"><? echo $row_s_top5_tcp['dst_port'];?></td>
		<td bgcolor="#00CCFF" class="style1"><? printf("%0.2f", ( $row_s_top5_tcp['TEST']/(1024*1024)));?></td>
	</tr>
		<? }?>
</table>
</td>
<td>
<table border="1" cellpadding="0" cellspacing="3" bordercolor="#000000" bgcolor="#ff0000">
	<tr>
		<td colspan="3" align="center" bgcolor="#ff9933" class="style1"> TCP RECEIVING</td>
	</tr>
	<tr>
		<td bgcolor="#ffcc33" class="style1">Port</td>
		<td bgcolor="#ffcc33" class="style1">MBytes</td>
	</tr><? while ($row_r_top5_tcp=mysql_fetch_array($res_r_top5_tcp)) {?>
	<tr>
		
		<td bgcolor="#00CCFF" class="style1"><? echo $row_r_top5_tcp['src_port'];?></td>
		<td bgcolor="#00CCFF" class="style1"><? printf("%0.2f", ( $row_r_top5_tcp['TEST']/(1024*1024)));?></td>
	</tr><? }?>
</table>
</td>
</tr>

<tr valign="top"><td>
<table border="1" cellpadding="0" cellspacing="3" bordercolor="#000000" bgcolor="#ff0000">
	<tr>
		<td colspan="3" align="center" bgcolor="#ff9933" class="style1"> UDP SENDING</td>
	</tr>
	<tr>
		<td bgcolor="#ffcc33" class="style1">Port</td>
		<td bgcolor="#ffcc33" class="style1">MBytes</td>
	</tr>
		<? while ($row_s_top5_udp=mysql_fetch_array($res_s_top5_udp)) {?>
	<tr>
		<td bgcolor="#00CCFF" class="style1"><? echo $row_s_top5_udp['dst_port'];?></td>
		<td bgcolor="#00CCFF" class="style1"><? printf("%0.2f", ( $row_s_top5_udp['TEST']/(1024*1024)));?></td>
	</tr>
		<? }?>
</table>
</td>
<td>
<table border="1" cellpadding="0" cellspacing="3" bordercolor="#000000" bgcolor="#ff0000">
	<tr>
		<td colspan="3" align="center" bgcolor="#ff9933" class="style1"> UDP RECEIVING</td>
	</tr>
	<tr>
		<td bgcolor="#ffcc33" class="style1">Port</td>
		<td bgcolor="#ffcc33" class="style1">MBytes</td>
	</tr><? while ($row_r_top5_udp=mysql_fetch_array($res_r_top5_udp)) {?>
	<tr>
		
		<td bgcolor="#00CCFF" class="style1"><? echo $row_r_top5_udp['src_port'];?></td>
		<td bgcolor="#00CCFF" class="style1"><? printf("%0.2f", ( $row_r_top5_udp['TEST']/(1024*1024)));?></td>
		
	</tr><? }?>
</table>
</td>
</tr>
</table>
