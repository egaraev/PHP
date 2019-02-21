<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<?php
$link=mysql_connect('localhost','root','');
mysql_select_db('ipacc');


// monthes function
function get_month($month_num)
{
$monthes=array(1 => "January", 2 => "February", 3 => "March", 4 => "April", 5 => "May", 6 => "June",7 => "Jule", 8 => "August", 9 => "September" , 10 => "October", 11 => "November", 12 => "December");
return $monthes[$month_num];
}
//LAN parametrs
$net='192.168.0.';
?>

</head>
<body>
<!--- Nachalo osnovnogo  table --->
<table border="0" width="100%" height="100%">
<tr><td valign="top">
<!--- Nachalo osnovnogo  table --->

<table border="01" width="100%" height="30%" bordercolor="black" cellpadding="1" cellspacing="0">
<?php
$query=mysql_query("SELECT DISTINCT year FROM `new` ORDER BY year DESC");
for ($i=0; $i<mysql_num_rows($query); $i++)
{

$f=mysql_fetch_array($query);
$querym=mysql_query("SELECT DISTINCT `month` FROM `new` where year='".$f[year]."' ORDER BY month DESC");

?>
<tr><td bgcolor="#FFFF99"><b>Year:</b></td><td bgcolor="#FFFF99"><b><?  echo "$f[year]"; ?></b></td></tr>

<tr><td bgcolor="#99FFFF"><b>Month:</b></td><td bgcolor="#99FFFF">
<?
		for ($q=0; $q<mysql_num_rows($querym); $q++)
				{
				$fm=mysql_fetch_array($querym);
				
 echo  '<a href="?month='.$fm[month].'&year='.$f[year].'">'.get_month($fm[month]).'</a>&nbsp;';

				}
			echo	'</td></tr>';
}
?>
</td></tr>
</table>


</td>
<!--- Konec osnovnogo pervogo i nachalo vtorogo table --->
<td valign="top">

<table width="100%" align="right" border="1" bordercolor="black" cellpadding="1" cellspacing="0">
<tr>
<td align="center" bgcolor="#FFFF99"><b>Date </b></td>
<td align="center" bgcolor="#FFFF99"><b>Sent (MB)</b></td>
<td align="center" bgcolor="#FFFF99"> <b>Received (MB)</b></td>
<td align="center" bgcolor="#FFFF99"> <b>TCP</b></td>
<td align="center" bgcolor="#FFFF99"> <b>UDP</b></td>
<td align="center" bgcolor="#FFFF99"> <b>ICMP</b></td>
<td align="center" bgcolor="#FFFF99"> <b>Other</b></td>
</tr>

<?

$year=(int)$_GET['year'];
$month=(int)$_GET['month'];
$day=(int)$_GET['day'];
////	
$queryd=mysql_query("SELECT DISTINCT day FROM `new` WHERE year='".$year."' AND month='".$month."'  ORDER BY day ASC");

////
	
for ($i=0; $i<mysql_num_rows($queryd); $i++)
////				
{
$fd=mysql_fetch_array($queryd);

///sent
$sent=mysql_query("SELECT sum(bytes) FROM `new` WHERE year='".$year."' AND month='".$month."' AND day='".$fd[day]."' AND src_ip like '".$net."%' ");
///received
$rec=mysql_query("SELECT sum(bytes) FROM `new` WHERE year='".$year."' AND month='".$month."' AND day='".$fd[day]."' AND dst_ip like '".$net."%' ");
///summ sent
$sentsum=mysql_query("SELECT sum(bytes) FROM `new` WHERE year='".$year."' AND month='".$month."' AND src_ip like '".$net."%' ");
///summ received
$recsum=mysql_query("SELECT sum(bytes) FROM `new` WHERE year='".$year."' AND month='".$month."' AND dst_ip like '".$net."%'");

//////////////////////////////TCP TRAFIC
///TCP -sent
$tcpsent=mysql_query("SELECT sum(bytes) FROM `new` WHERE year='".$year."' AND month='".$month."' AND day='".$fd[day]."' AND src_ip like '".$net."%'  AND proto='6' ");
///TCP sent sum
$tcpsentsum=mysql_query("SELECT sum(bytes) FROM `new` WHERE year='".$year."' AND month='".$month."' AND src_ip like '".$net."%' AND proto='6' ");
/// TCP REC
$tcprec=mysql_query("SELECT sum(bytes) FROM `new` WHERE year='".$year."' AND month='".$month."' AND day='".$fd[day]."' AND dst_ip like '".$net."%' AND proto='6' ");
//TCP rec sum
$tcprecsum=mysql_query("SELECT sum(bytes) FROM `new` WHERE year='".$year."' AND month='".$month."'  AND dst_ip like '".$net."%' AND proto='6' ");


////////////////////////////////////////////////////////UDP TRAFIC

///UDP -sent
$udpsent=mysql_query("SELECT sum(bytes) FROM `new` WHERE year='".$year."' AND month='".$month."' AND day='".$fd[day]."' AND src_ip like '".$net."%'  AND proto='17' ");
///UDP sent sum
$udpsentsum=mysql_query("SELECT sum(bytes) FROM `new` WHERE year='".$year."' AND month='".$month."' AND src_ip like '".$net."%' AND proto='17' ");
/// UDP REC
$udprec=mysql_query("SELECT sum(bytes) FROM `new` WHERE year='".$year."' AND month='".$month."' AND day='".$fd[day]."' AND dst_ip like '".$net."%' AND proto='17' ");
//UDP rec sum
$udprecsum=mysql_query("SELECT sum(bytes) FROM `new` WHERE year='".$year."' AND month='".$month."'  AND dst_ip like '".$net."%' AND proto='17' ");

////////ICMP TRAFIC
///ICMP -sent
$icmpsent=mysql_query("SELECT sum(bytes) FROM `new` WHERE year='".$year."' AND month='".$month."' AND day='".$fd[day]."' AND src_ip like '".$net."%'  AND proto='1' ");
///ICMP sent sum
$icmpsentsum=mysql_query("SELECT sum(bytes) FROM `new` WHERE year='".$year."' AND month='".$month."' AND src_ip like '".$net."%'  AND proto='1' ");
/// ICMP REC
$icmprec=mysql_query("SELECT sum(bytes) FROM `new` WHERE year='".$year."' AND month='".$month."' AND day='".$fd[day]."' AND dst_ip like '".$net."%' AND proto='1' ");
//ICMP rec sum
$icmprecsum=mysql_query("SELECT sum(bytes) FROM `new` WHERE year='".$year."' AND month='".$month."'  AND dst_ip like '".$net."%' AND proto='1' ");

////////OTHER TRAFIC
///OTHER -sent
$othersent=mysql_query("SELECT sum(bytes) FROM `new` WHERE year='".$year."' AND month='".$month."' AND day='".$fd[day]."' AND src_ip like '".$net."%'  AND proto!=17 AND proto!=6 AND proto!=1 ");
///OTHER sent sum
$othersentsum=mysql_query("SELECT sum(bytes) FROM `new` WHERE year='".$year."' AND month='".$month."' AND src_ip like '".$net."%'  AND proto!=17 AND proto!=6 AND proto!=1 ");
/// OTHER REC
$otherrec=mysql_query("SELECT sum(bytes) FROM `new` WHERE year='".$year."' AND month='".$month."' AND day='".$fd[day]."' AND dst_ip like '".$net."%' AND proto!=17 AND proto!=6 AND proto!=1 ");
//OTHER rec sum
$otherrecsum=mysql_query("SELECT sum(bytes) FROM `new` WHERE year='".$year."' AND month='".$month."'  AND dst_ip like '".$net."%' AND proto!=17 AND proto!=6 AND proto!=1 ");



$fsent=mysql_fetch_array($sent);
$frec=mysql_fetch_array($rec);
$fsentsum=mysql_fetch_array($sentsum);
$frecsum=mysql_fetch_array($recsum);
////////TCP
$ftcpsent=mysql_fetch_array($tcpsent);
$ftcpsentsum=mysql_fetch_array($tcpsentsum);
$ftcprec=mysql_fetch_array($tcprec);
$ftcprecsum=mysql_fetch_array($tcprecsum);
///////UDP
$fudpsent=mysql_fetch_array($udpsent);
$fudpsentsum=mysql_fetch_array($udpsentsum);
$fudprec=mysql_fetch_array($udprec);
$fudprecsum=mysql_fetch_array($udprecsum);

///////ICMP
$ficmpsent=mysql_fetch_array($icmpsent);
$ficmpsentsum=mysql_fetch_array($icmpsentsum);
$ficmprec=mysql_fetch_array($icmprec);
$ficmprecsum=mysql_fetch_array($icmprecsum);

///////OTHER
$fothersent=mysql_fetch_array($othersent);
$fothersentsum=mysql_fetch_array($othersentsum);
$fotherrec=mysql_fetch_array($otherrec);
$fotherrecsum=mysql_fetch_array($otherrecsum);


//var_dump($fs);
/////
echo '<tr>';
////
echo     '<td align="center" bgcolor="#99FFFF"><a href="ipstat.php?month='.$month.'&year='.$year.'&day='.$fd[day].'">'.$fd[day].'.'.$month.'.'.$year.'</a></td>';
echo     '<td align="center" bgcolor="#99FFFF">'.sprintf("%.2f", $fsent[0]/(1024*1024)).'</td>';
echo     '<td align="center" bgcolor="#99FFFF">'.sprintf("%.2f", $frec[0]/(1024*1024)).'</td>';

echo     '<td align="center" bgcolor="#99FFFF">'.sprintf("%.2f", $ftcpsent[0]/(1024*1024)).'&nbsp;/&nbsp; '.sprintf("%.2f", $ftcprec[0]/(1024*1024)).'</td>';
echo     '<td align="center" bgcolor="#99FFFF">'.sprintf("%.2f", $fudpsent[0]/(1024*1024)).'&nbsp;/&nbsp; '.sprintf("%.2f", $fudprec[0]/(1024*1024)).'</td>';

echo     '<td align="center" bgcolor="#99FFFF">'.sprintf("%.2f", $ficmpsent[0]/(1024*1024)).'&nbsp;/&nbsp; '.sprintf("%.2f", $ficmprec[0]/(1024*1024)).'</td>';


echo     '<td align="center" bgcolor="#99FFFF">'.sprintf("%.2f", $fothersent[0]/(1024*1024)).'&nbsp;/&nbsp; '.sprintf("%.2f", $fotherrec[0]/(1024*1024)).'</td>';
//////




echo	'</td></tr>';

}
echo     '<tr><td align="center" bgcolor="#FFFF99">Total:</td>';
echo     '<td align="center" bgcolor="#FFFF99">'.sprintf("%.2f", $fsentsum[0]/(1024*1024)).'</td>';	
echo     '<td align="center" bgcolor="#FFFF99">'.sprintf("%.2f", $frecsum[0]/(1024*1024)).'</td>';
echo     '<td align="center" bgcolor="#FFFF99">'.sprintf("%.2f", $ftcpsentsum[0]/(1024*1024)).'&nbsp;/&nbsp; '.sprintf("%.2f", $ftcprecsum[0]/(1024*1024)).'</td>';
echo     '<td align="center" bgcolor="#FFFF99">'.sprintf("%.2f", $fudpsentsum[0]/(1024*1024)).'&nbsp;/&nbsp; '.sprintf("%.2f", $fudprecsum[0]/(1024*1024)).'</td>';
echo     '<td align="center" bgcolor="#FFFF99">'.sprintf("%.2f", $ficmpsentsum[0]/(1024*1024)).'&nbsp;/&nbsp; '.sprintf("%.2f", $ficmprecsum[0]/(1024*1024)).'</td>';
echo     '<td align="center" bgcolor="#FFFF99">'.sprintf("%.2f", $fothersentsum[0]/(1024*1024)).'&nbsp;/&nbsp; '.sprintf("%.2f", $fotherrecsum[0]/(1024*1024)).'</td>';

echo '<title>Statistic for '.get_month($month).' '.$year.'   </title>';
?>


</table>






<!--- Konec osnovnogo  table --->
</td></tr>
</table>
<!--- Konec osnovnogo table --->


</body>
</html>
