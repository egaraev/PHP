<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>IP statistic</title>
</head>

<body>
<? 
	//users
function get_user($host)
{
$users{'gateway.isetech.az'}='Gateway';
$users{'192.168.0.2'}='Server';
$users{'192.168.0.30'}='Nadir';                           
$users{'192.168.0.31'}='Zaur'; 
$users{'192.168.0.32'}='Ruslan';                          
$users{'192.168.0.33'}='Niyaz';
$users{'192.168.0.134'}='Reception'; 
$users{'192.168.0.35'}='Ayaz Notebook';
$users{'192.168.0.36'}='Orxan Notebook';
$users{'192.168.0.37'}='Orxan  PC';          
$users{'192.168.0.39'}='Halid';                      
$users{'192.168.0.40'}='Ayaz PC';
$users{'192.168.0.41'}='Ali';                        
$users{'192.168.0.42'}='Firuza';                            
$users{'192.168.0.44'}='Farman';
$users{'192.168.0.45'}='Anar';
$users{'192.168.0.55'}='Samid';
$users{'192.168.0.70'}='TEST';
$users{'192.168.0.71'}='TEST1';
$users{'192.168.0.72'}='TEST2';
$users{'192.168.0.73'}='TEST3';
$users{'192.168.0.74'}='TEST4';
$users{'192.168.0.75'}='Emin';
$users{'192.168.0.100'}='Eldar Notebook';
$users{'192.168.0.101'}='Eldar Limited Rights';
$users{'192.168.0.105'}='Eldar PC';
$users{'192.168.0.110'}='Eldar Notebook Wireless';
$users{'192.168.0.115'}='Eldar Virtual Machines';
$users{'192.168.0.130'}='Nadir Notebook';
$users{'192.168.0.250'}='Andrew';
$users{'192.168.0.252'}='Andrew WIFI';
$users{'192.168.0.4'}='D-Link WiFi AP';
$users{'192.168.0.5'}='Isetech Web Server';
$users{'192.168.0.50'}='Tural';
$users{'192.168.0.51'}='Tural WiFI';
$users{'192.168.0.60'}='Nadir`s Virtual PC';
return $users[$host];
}

//LAN parametrs
$net='192.168.0.';
	
$link=mysql_connect('localhost','root','');
mysql_select_db('ipacc');

$year=(int)$_GET['year'];
$month=(int)$_GET['month'];
$day=(int)$_GET['day'];

?>


	
<!--- Nachalo osnovnogo  table --->
<table border="2" width="100%" height="100%">
<tr>
<!--- Nachalo osnovnogo  table --->


<!--- Konec osnovnogo pervogo i nachalo vtorogo table --->
<td valign="top">

<table width="100%" align="right" border="1"  bordercolor="black" cellpadding="1" cellspacing="0">
<tr>
<td align="center" bgcolor="#FFFF99"><b>IP address</b></td>
<td align="center" bgcolor="#FFFF99"><b>Sent</b></td>
<td align="center" bgcolor="#FFFF99"> <b>Received</b></td>
<td align="center" bgcolor="#FFFF99"> <b>TCP</b></td>
<td align="center" bgcolor="#FFFF99"> <b>UDP</b></td>
<td align="center" bgcolor="#FFFF99"> <b>ICMP</b></td>
<td align="center" bgcolor="#FFFF99"> <b>Other</b></td>
</tr>
<? 
//echo "IP addresses:&nbsp;&nbsp;";
$queryip=mysql_query("SELECT DISTINCT src_ip FROM `new` WHERE year='".$year."' AND month='".$month."'   AND day='".$day."' and src_ip like '".$net."%' "  );	
for ($q=0; $q<mysql_num_rows($queryip); $q++)
				{
$fip=mysql_fetch_array($queryip);

////SENT
$sent=mysql_query("SELECT sum(bytes) FROM `new` WHERE year='".$year."' AND month='".$month."' AND day='".$day."' AND src_ip='".$fip[src_ip]."' ");
////REC
$rec=mysql_query("SELECT sum(bytes) FROM `new` WHERE year='".$year."' AND month='".$month."' AND day='".$day."' AND dst_ip='".$fip[src_ip]."' ");
///summ sent
$sentsum=mysql_query("SELECT sum(bytes) FROM `new` WHERE year='".$year."' AND month='".$month."' AND day='".$day."' AND src_ip like '".$net."%' ");
///summ received
$recsum=mysql_query("SELECT sum(bytes) FROM `new` WHERE year='".$year."' AND month='".$month."' AND day='".$day."' AND dst_ip like '".$net."%'");

//////////////////////////////TCP TRAFIC
///TCP -sent
$tcpsent=mysql_query("SELECT sum(bytes) FROM `new` WHERE year='".$year."' AND month='".$month."' AND day='".$day."' AND src_ip='".$fip[src_ip]."'  AND proto='6' ");
///TCP sent sum
$tcpsentsum=mysql_query("SELECT sum(bytes) FROM `new` WHERE year='".$year."' AND month='".$month."' AND day='".$day."' AND src_ip like '".$net."%' AND proto='6' ");
/// TCP REC
$tcprec=mysql_query("SELECT sum(bytes) FROM `new` WHERE year='".$year."' AND month='".$month."' AND day='".$day."' AND dst_ip='".$fip[src_ip]."' AND proto='6' ");
//TCP rec sum
$tcprecsum=mysql_query("SELECT sum(bytes) FROM `new` WHERE year='".$year."' AND month='".$month."' AND day='".$day."'  AND dst_ip like '".$net."%' AND proto='6' ");


////////////////////////////////////////////////////////UDP TRAFIC

///UDP -sent
$udpsent=mysql_query("SELECT sum(bytes) FROM `new` WHERE year='".$year."' AND month='".$month."' AND day='".$day."' AND src_ip='".$fip[src_ip]."'  AND proto='17' ");
///UDP sent sum
$udpsentsum=mysql_query("SELECT sum(bytes) FROM `new` WHERE year='".$year."' AND month='".$month."' AND day='".$day."' AND src_ip like '".$net."%' AND proto='17' ");
/// UDP REC
$udprec=mysql_query("SELECT sum(bytes) FROM `new` WHERE year='".$year."' AND month='".$month."' AND day='".$day."' AND dst_ip='".$fip[src_ip]."' AND proto='17' ");
//UDP rec sum
$udprecsum=mysql_query("SELECT sum(bytes) FROM `new` WHERE year='".$year."' AND month='".$month."' AND day='".$day."' AND dst_ip like '".$net."%' AND proto='17' ");

////////ICMP TRAFIC
///ICMP -sent
$icmpsent=mysql_query("SELECT sum(bytes) FROM `new` WHERE year='".$year."' AND month='".$month."' AND day='".$day."' AND src_ip='".$fip[src_ip]."'  AND proto='1' ");
///ICMP sent sum
$icmpsentsum=mysql_query("SELECT sum(bytes) FROM `new` WHERE year='".$year."' AND month='".$month."' AND day='".$day."' AND src_ip like '".$net."%'  AND proto='1' ");
/// ICMP REC
$icmprec=mysql_query("SELECT sum(bytes) FROM `new` WHERE year='".$year."' AND month='".$month."' AND day='".$day."' AND dst_ip='".$fip[src_ip]."' AND proto='1' ");
//ICMP rec sum
$icmprecsum=mysql_query("SELECT sum(bytes) FROM `new` WHERE year='".$year."' AND month='".$month."' AND day='".$day."' AND dst_ip like '".$net."%' AND proto='1' ");

////////OTHER TRAFIC
///OTHER -sent
$othersent=mysql_query("SELECT sum(bytes) FROM `new` WHERE year='".$year."' AND month='".$month."' AND day='".$day."' AND src_ip='".$fip[src_ip]."'  AND proto!=17 AND proto!=6 AND proto!=1 ");
///OTHER sent sum
$othersentsum=mysql_query("SELECT sum(bytes) FROM `new` WHERE year='".$year."' AND month='".$month."' AND day='".$day."' AND src_ip like '".$net."%'  AND proto!=17 AND proto!=6 AND proto!=1 ");
/// OTHER REC
$otherrec=mysql_query("SELECT sum(bytes) FROM `new` WHERE year='".$year."' AND month='".$month."' AND day='".$day."' AND dst_ip='".$fip[src_ip]."' AND proto!=17 AND proto!=6 AND proto!=1 ");
//OTHER rec sum
$otherrecsum=mysql_query("SELECT sum(bytes) FROM `new` WHERE year='".$year."' AND month='".$month."' AND day='".$day."'  AND dst_ip like '".$net."%' AND proto!=17 AND proto!=6 AND proto!=1 ");



///////// ARRAYS
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

echo '<tr>';

//get_month($fm[month])
echo     '<td bgcolor="#99FFFF"><a href="more.php?month='.$month.'&year='.$year.'&day='.$day.'&ip='.$fip[src_ip].'">'.get_user($fip[src_ip]).'</a></td>';
echo     '<td align="center" bgcolor="#99FFFF">'.sprintf("%.2f", $fsent[0]/(1024*1024)).'</td>';
echo     '<td align="center" bgcolor="#99FFFF">'.sprintf("%.2f", $frec[0]/(1024*1024)).'</td>';
echo     '<td align="center" bgcolor="#99FFFF">'.sprintf("%.2f", $ftcpsent[0]/(1024*1024)).'&nbsp;/&nbsp; '.sprintf("%.2f", $ftcprec[0]/(1024*1024)).'</td>';
echo     '<td align="center" bgcolor="#99FFFF">'.sprintf("%.2f", $fudpsent[0]/(1024*1024)).'&nbsp;/&nbsp; '.sprintf("%.2f", $fudprec[0]/(1024*1024)).'</td>';

echo     '<td align="center" bgcolor="#99FFFF">'.sprintf("%.2f", $ficmpsent[0]/(1024*1024)).'&nbsp;/&nbsp; '.sprintf("%.2f", $ficmprec[0]/(1024*1024)).'</td>';


echo     '<td align="center" bgcolor="#99FFFF">'.sprintf("%.2f", $fothersent[0]/(1024*1024)).'&nbsp;/&nbsp; '.sprintf("%.2f", $fotherrec[0]/(1024*1024)).'</td>';




echo	'</td></tr>';
				}

echo     '<tr><td align="center" bgcolor="#FFFF99">Total:</td>';
echo     '<td align="center" bgcolor="#FFFF99">'.sprintf("%.2f", $fsentsum[0]/(1024*1024)).'</td>';	
echo     '<td align="center" bgcolor="#FFFF99">'.sprintf("%.2f", $frecsum[0]/(1024*1024)).'</td>';
echo     '<td align="center" bgcolor="#FFFF99">'.sprintf("%.2f", $ftcpsentsum[0]/(1024*1024)).'&nbsp;/&nbsp; '.sprintf("%.2f", $ftcprecsum[0]/(1024*1024)).'</td>';
echo     '<td align="center" bgcolor="#FFFF99">'.sprintf("%.2f", $fudpsentsum[0]/(1024*1024)).'&nbsp;/&nbsp; '.sprintf("%.2f", $fudprecsum[0]/(1024*1024)).'</td>';
echo     '<td align="center" bgcolor="#FFFF99">'.sprintf("%.2f", $ficmpsentsum[0]/(1024*1024)).'&nbsp;/&nbsp; '.sprintf("%.2f", $ficmprecsum[0]/(1024*1024)).'</td>';
echo     '<td align="center" bgcolor="#FFFF99">'.sprintf("%.2f", $fothersentsum[0]/(1024*1024)).'&nbsp;/&nbsp; '.sprintf("%.2f", $fotherrecsum[0]/(1024*1024)).'</td>';
?>


</table>






<!--- Konec osnovnogo  table --->
</td></tr>
</table>
<!--- Konec osnovnogo table --->	
	
</body>
</html>
