#!/usr/bin/perl

use Mysql;
use Socket;
use CGI qw(:standard);

$year= param('year');
$month = param('month');
$day = param ('day');
$mode = param('mode');
######################################## Added by Nadir 07.08.2006

$doit  = param('doit');


########################################
$db_host = "localhost";
$db_user = "root";
$db_pass = "nadir";
$db_db = "ipacc";
$db_table = "new";

%month2dec = ( 1 => "January", 2 => "February", 3 => "March", 4 => "April", 5 => "May", 6 => "June",
               7 => "Jule", 8 => "August", 9 => "September" , 10 => "October", 11 => "November", 12 => "December");
	       
$net = '192.168.0.';

$dbh = Mysql->Connect($db_host,$db_db,$db_user,$db_pass);

#1# Printing Header.

print "Content-type: text/html\n\n";
$header = "<HTML>\n";
$header .= "<HEAD><TITLE>Report about using internet for ".$month2dec{$month}.", ".$year." year.<\/TITLE><\/HEAD>\n";
$header .= "<BODY>\n";

#1# End header.

#2# Calendar

$body = "<TABLE align=\"left\" width=25% bgcolor=\"beige\" border=\"1\" bordercolor=\"black\" cellpadding=\"1\" cellspacing=\"0\">\n";

#3# Making query to the database. Selecting all years from database.
$query = "SELECT DISTINCT year FROM ".$db_table." ORDER BY year ASC";
$year_query = $dbh->Query($query);
#3# End query

if(!$year)
{
    $sch = 1;
    %tmp = $year_query->fetchhash;
    $year = $tmp{year};
}

## How many rows have been selected
$number_of_years = $year_query->numrows;

#4# View all rows
for($j = 0; $j < $number_of_years; $j++)
{
    $year_query->dataseek($j);
	
	## Fetching hash.
    %year_hash = $year_query->fetchhash;
	
    $body .= "<TR BGCOLOR=beige>\n";
    $body .= "<TD>Years:<\/TD>\n";	
	
	
    if(($year == $year_hash{year}))
    {
        $body .= "<TD BGCOLOR=\"ff9933\" ALIGN=\"CENTER\">";
    } else {
        $body .= "<TD ALIGN=\"CENTER\">";
    }
	$body .= "<TABLE BORDER=\"0\" WIDTH=\"100%\" bordercolor=\"black\" cellpadding=\"1\" cellspacing=\"0\">\n";
	$body .= "<TR>";
	$body .= "<A HREF=\"?year=".$year_hash{year}."\">".$year_hash{year}."<\/A>";
	$body .= "<\/TR>";
	$body .= "<TR>";
	$body .= "<TD ALIGN=\"CENTER\">";
	$body .= "<A HREF=\"?year=".$year_hash{year}."&mode=ip\">View by ip([ip]).<\/A>";
	$body .= "<\/TD>";
	$body .= "<\/TR>";
	$body .= "<\/TABLE>";
	$body .= "<\/TD>\n";
    $body .= "<\/TR>";
		
    $body .= "<TR BGCOLOR=beige>\n";
    $body .= "<TD>Days:<\/TD>\n";
    $body .= "<TD>\n";
    $body .= "<TABLE BORDER=\"0\" WIDTH=\"100%\" bordercolor=\"black\" cellpadding=\"1\" cellspacing=\"0\">\n";
    $body .= "<TR>\n";
	
	
    $query = "SELECT DISTINCT month FROM ".$db_table." WHERE year='".$year_hash{year}."' ORDER BY month ASC";
    $month_query = $dbh->Query($query);
    %month_hash = $month_query->fetchhash;	
    
    if(!$month && $sch)
    {
	$month = $month_hash{month};
    }
        
    for($d = 1; $d <= 12; $d++)
    {
        if($month_hash{month} == $d )
        {
	    if (($month_hash{month} == $month) && ($year_hash{year} == $year))
	    {
	        $body .= "<TD BGCOLOR=\"ff9933\" ALIGN=\"CENTER\">";
	    } 
	    else
	    {
	        $body .= "<TD ALIGN=\"CENTER\">";
	    }
	    $body .= "<A HREF=\"?year=".$year_hash{year}."&month=".$month_hash{month}."\">".$month_hash{month}."<\/A>";
	    $body .= " [<A HREF=\"?year=".$year_hash{year}."&month=".$month_hash{month}."&mode=ip\">ip<\/A>]";
	    $body .= "<\/TD>\n";
	    %month_hash = $month_query->fetchhash;
	} 

	else 
	{
	    $body .= "<TD ALIGN=CENTER>".$d."<\/TD>\n";
	}
    }
    
    
    $body .= "<\/TR>\n";
    $body .= "<\/TABLE>\n";
    $body .= "<\/TD><\/TR>";
}
#4# End of rows.

$body .= "<\/TABLE>\n";
#2# End Calendar


$body .= "<TABLE width=\"60%\" align=\"center\" bgcolor=\"red\" border=\"1\" bordercolor=\"black\" cellpadding=\"1\" cellspacing=\"0\" width=50%>";
#################################################################################################################################################
        if(!($month))
        {
            # Only year
            $body .= "<TR>\n";
	    $body .= "<h2><FONT COLOR=\"GREEN\"><CENTER>Report about using internet ".$year." year.<\/CENTER><\/FONT><\/h2>\n";
	    $body .= "<\/TR>\n";
        } else
        {
            if ($month && (!($day)))
            {
                # Year and month
                $body .= "<TR>\n";
		$body .= "<h2><FONT COLOR=\"GREEN\"><CENTER>Report about using internet ".$month2dec{$month}.", ".$year." year.<\/CENTER><\/FONT><\/h2>\n";
		$body .= "<\/TR>\n";
            } else {
                # Year, month and day
                $lday = sprintf("%.2d", $day);
                $lmonth = sprintf("%.2d", $month);
                $body .= "<TR>\n";
		$body .= "<h2><FONT COLOR=\"GREEN\"><CENTER>Report about using internet ".$lday.".".$lmonth.".".$year.".<\/CENTER><\/FONT><\/h2>\n";
		$body .= "<\/TR>\n";
            }
        }


$body .= "<TR BGCOLOR=\"ffcc33\">\n";
if( ($mode eq 'ip') || (($month && $day))){ 
$body .= "<TD ALIgN=\"CENTER\"><b>IP<\/b><\/TD>\n";
}
else
{
$body .= "<TD ALIgN=\"CENTER\"><b>Date<\/b><\/td>\n";
}
$body .= "<TD ALIGN=\"CENTER\"><b>sent<\/b><\/TD>\n";
$body .= "<TD ALIGN=\"CENTER\"> <b>Received<\/b><\/TD>\n";
############################################################## Added by Nadir 02.08.2006

$body .= "<TD ALIGN=\"CENTER\"> <b>TCP</b><\/TD>\n";
$body .= "<TD ALIGN=\"CENTER\"> <b>UDP</b><\/TD>\n";
$body .= "<TD ALIGN=\"CENTER\"> <b>ICMP</b><\/TD>\n";
$body .= "<TD ALIGN=\"CENTER\"> <b>Other</b><\/TD>\n";

##############################################################
    if(!($month))
    {
# Only year
	if($mode eq 'ip')
	{
	    $querys = "select src_ip as first, sum(bytes) as second from ".$db_table." where year='".$year."' and src_ip like '".$net."%' group by src_ip";
	    $queryr = "select dst_ip as first, sum(bytes) as second from ".$db_table." where dst_ip like '".$net."%' and year='".$year."'  group by dst_ip";
	}
	else
	{
	    $querys = "select month as first, sum(bytes) as second from ".$db_table." where src_ip like '".$net."%' and year='".$year."'  group by month";
	    $queryr = "select month as first, sum(bytes) as second from ".$db_table." where dst_ip like '".$net."%' and year='".$year."'  group by month";
	}
    } else
    {
        if ($month && (!($day)))
        {
# Year and month
	    if($mode eq 'ip')
	    {
		$querys = "select src_ip as first, sum(bytes) as second from ".$db_table." where year='".$year."' and month='".$month."' and src_ip like '".$net."%' group by src_ip";
		$queryr = "select dst_ip as first, sum(bytes) as second from ".$db_table." where year='".$year."' and month='".$month."' and dst_ip like '".$net."%' group by dst_ip";

############################################################## Added by Nadir 02.08.2006
		$querys_tcp  ="select src_ip as first, sum(bytes) as second from ".$db_table."  where year='".$year."'  and month='".$month."'  and src_ip like '".$net."%' and proto=6   group by src_ip";
		$queryr_tcp  ="select dst_ip as first, sum(bytes) as second from ".$db_table."  where year='".$year."'  and month='".$month."'  and dst_ip like '".$net."%' and proto=6   group by dst_ip";

		$querys_icmp ="select src_ip as first, sum(bytes) as second from ".$db_table."  where year='".$year."'  and month='".$month."'  and src_ip like '".$net."%' and proto=1   group by src_ip";
		$queryr_icmp ="select dst_ip as first, sum(bytes) as second from ".$db_table."  where year='".$year."'  and month='".$month."'  and dst_ip like '".$net."%' and proto=1   group by dst_ip";

		$querys_udp  ="select src_ip as first, sum(bytes) as second from ".$db_table."  where year='".$year."'  and month='".$month."'  and src_ip like '".$net."%' and proto=17  group by src_ip";
		$queryr_udp  ="select dst_ip as first, sum(bytes) as second from ".$db_table."  where year='".$year."'  and month='".$month."'  and dst_ip like '".$net."%' and proto=17  group by dst_ip";

		$querys_other  ="select src_ip as first, sum(bytes) as second from ".$db_table."  where year='".$year."'  and month='".$month."'  and src_ip like '".$net."%' and proto!=17 and proto!=6 and proto!=1  group by src_ip";
		$queryr_other  ="select dst_ip as first, sum(bytes) as second from ".$db_table."  where year='".$year."'  and month='".$month."'  and dst_ip like '".$net."%' and proto=17  and proto!=6 and proto!=1  group by dst_ip";
###############################  Added by Nadir 07.08.2006

		$querys_tcp_21		="SELECT sum(bytes)  FROM `new` WHERE `src_ip` LIKE  '192.168.1.1' AND `src_port` =21 group by `src_ip`";
		$querys_tcp_22		="SELECT sum(bytes)  FROM `new` WHERE `src_ip` LIKE  '192.168.1.1' AND `src_port` =22 group by `src_ip`";
		$querys_tcp_23		="SELECT sum(bytes)  FROM `new` WHERE `src_ip` LIKE  '192.168.1.1' AND `src_port` =23 group by `src_ip`";
		$querys_tcp_25		="SELECT sum(bytes)  FROM `new` WHERE `src_ip` LIKE  '192.168.1.1' AND `src_port` =25 group by `src_ip`";
		$querys_tcp_80		="SELECT sum(bytes)  FROM `new` WHERE `src_ip` LIKE  '192.168.1.1' AND `src_port` =80 group by `src_ip`";
		$querys_tcp_110		="SELECT sum(bytes)  FROM `new` WHERE `src_ip` LIKE  '192.168.1.1' AND `src_port` =110 group by `src_ip`";
		$querys_tcp_143		="SELECT sum(bytes)  FROM `new` WHERE `src_ip` LIKE  '192.168.1.1' AND `src_port` =143 group by `src_ip`";
		$querys_tcp_443		="SELECT sum(bytes)  FROM `new` WHERE `src_ip` LIKE  '192.168.1.1' AND `src_port` =443 group by `src_ip`";
		$querys_tcp_993		="SELECT sum(bytes)  FROM `new` WHERE `src_ip` LIKE  '192.168.1.1' AND `src_port` =993 group by `src_ip`";

		$queryr_tcp_21		="SELECT sum(bytes)  FROM `new` WHERE `dst_ip` LIKE  '192.168.1.1' AND `src_port` =21 group by `src_ip`";
		$queryr_tcp_22		="SELECT sum(bytes)  FROM `new` WHERE `dst_ip` LIKE  '192.168.1.1' AND `src_port` =22 group by `src_ip`";
		$queryr_tcp_23		="SELECT sum(bytes)  FROM `new` WHERE `dst_ip` LIKE  '192.168.1.1' AND `src_port` =23 group by `src_ip`";
		$queryr_tcp_25		="SELECT sum(bytes)  FROM `new` WHERE `dst_ip` LIKE  '192.168.1.1' AND `src_port` =25 group by `src_ip`";
		$queryr_tcp_80		="SELECT sum(bytes)  FROM `new` WHERE `dst_ip` LIKE  '192.168.1.1' AND `src_port` =80 group by `src_ip`";
		$queryr_tcp_110		="SELECT sum(bytes)  FROM `new` WHERE `dst_ip` LIKE  '192.168.1.1' AND `src_port` =110 group by `src_ip`";
		$queryr_tcp_143		="SELECT sum(bytes)  FROM `new` WHERE `dst_ip` LIKE  '192.168.1.1' AND `src_port` =143 group by `src_ip`";
		$queryr_tcp_443		="SELECT sum(bytes)  FROM `new` WHERE `dst_ip` LIKE  '192.168.1.1' AND `src_port` =443 group by `src_ip`";
		$queryr_tcp_993		="SELECT sum(bytes)  FROM `new` WHERE `dst_ip` LIKE  '192.168.1.1' AND `src_port` =993 group by `src_ip`";
	
		$querys_udp_53		="SELECT sum(bytes)  FROM `new` WHERE `src_ip` LIKE  '192.168.1.1' AND `src_port` =119 group by `src_ip`";
		$querys_udp_161		="SELECT sum(bytes)  FROM `new` WHERE `src_ip` LIKE  '192.168.1.1' AND `src_port` =119 group by `src_ip`";

		$queryr_udp_53		="SELECT sum(bytes)  FROM `new` WHERE `dst_ip` LIKE  '192.168.1.1' AND `src_port` =119 group by `src_ip`";
		$queryr_udp_161		="SELECT sum(bytes)  FROM `new` WHERE `dst_ip` LIKE  '192.168.1.1' AND `src_port` =119 group by `src_ip`";


		$querys_other_5190	="SELECT sum(bytes)  FROM `new` WHERE `src_ip` LIKE  '192.168.1.1' AND `src_port` =119 group by `src_ip`";
		$queryr_other_119		="SELECT sum(bytes)  FROM `new` WHERE `dst_ip` LIKE  '192.168.1.1' AND `src_port` =119 group by `src_ip`";

###############################


##############################################################
	    }
	    else
	    {
    		$querys = "select day as first, sum(bytes) as second from ".$db_table." where src_ip like '".$net."%' and year='".$year."' and month='".$month."' group by day";
    		$queryr = "select day as first, sum(bytes) as second from ".$db_table." where dst_ip like '".$net."%' and year='".$year."' and month='".$month."' group by day";

############################################################## Added by Nadir 02.08.2006
		$querys_tcp  ="select day as first, sum(bytes) as second from ".$db_table." where src_ip like '".$net."%' and year='".$year."' and month='".$month."' and proto=6   group by day";
		$queryr_tcp  ="select day as first, sum(bytes) as second from ".$db_table." where dst_ip like '".$net."%' and year='".$year."' and month='".$month."' and proto=6   group by day";

		$querys_icmp ="select day as first, sum(bytes) as second from ".$db_table." where src_ip like '".$net."%' and year='".$year."' and month='".$month."' and proto=1   group by day";
		$queryr_icmp ="select day as first, sum(bytes) as second from ".$db_table." where dst_ip like '".$net."%' and year='".$year."' and month='".$month."' and proto=1   group by day";

		$querys_udp  ="select day as first, sum(bytes) as second from ".$db_table." where src_ip like '".$net."%' and year='".$year."' and month='".$month."' and proto=17  group by day";
		$queryr_udp  ="select day as first, sum(bytes) as second from ".$db_table." where dst_ip like '".$net."%' and year='".$year."' and month='".$month."' and proto=17  group by day";

		$querys_other  ="select day as first, sum(bytes) as second from ".$db_table." where src_ip like '".$net."%' and year='".$year."' and month='".$month."' and proto!=17 and proto!=6 and proto!=1  group by day";
		$queryr_other  ="select day as first, sum(bytes) as second from ".$db_table." where dst_ip like '".$net."%' and year='".$year."' and month='".$month."' and proto!=17 and proto!=6 and proto!=1  group by day";
##############################################################
	    }
        } else {
# Year, month and day
        $querys 	   = "select src_ip as first, sum(bytes) as second from ".$db_table." where src_ip like '".$net."%' and year='".$year."' and month='".$month."' and day='".$day."' 		    group by src_ip";
        $queryr 	   = "select dst_ip as first, sum(bytes) as second from ".$db_table." where dst_ip like '".$net."%' and year='".$year."' and month='".$month."' and day='".$day."' 		    group by dst_ip";
############################################################## Added by Nadir 02.08.2006
        $querys_tcp  = "select src_ip as first, sum(bytes) as second from ".$db_table." where src_ip like '".$net."%' and year='".$year."' and month='".$month."' and day='".$day."' and proto=6    group by src_ip";
        $queryr_tcp  = "select dst_ip as first, sum(bytes) as second from ".$db_table." where dst_ip like '".$net."%' and year='".$year."' and month='".$month."' and day='".$day."' and proto=6    group by dst_ip";

        $querys_icmp = "select src_ip as first, sum(bytes) as second from ".$db_table." where src_ip like '".$net."%' and year='".$year."' and month='".$month."' and day='".$day."' and proto=1    group by src_ip";
        $queryr_icmp = "select dst_ip as first, sum(bytes) as second from ".$db_table." where dst_ip like '".$net."%' and year='".$year."' and month='".$month."' and day='".$day."' and proto=1    group by dst_ip";

        $querys_udp  = "select src_ip as first, sum(bytes) as second from ".$db_table." where src_ip like '".$net."%' and year='".$year."' and month='".$month."' and day='".$day."' and proto=17   group by src_ip";
        $queryr_udp  = "select dst_ip as first, sum(bytes) as second from ".$db_table." where dst_ip like '".$net."%' and year='".$year."' and month='".$month."' and day='".$day."' and proto=17   group by dst_ip";

        $querys_other  = "select src_ip as first, sum(bytes) as second from ".$db_table." where src_ip like '".$net."%' and year='".$year."' and month='".$month."' and day='".$day."'  and proto!=17 and proto!=6 and proto!=1  group by src_ip";
        $queryr_other  = "select dst_ip as first, sum(bytes) as second from ".$db_table." where dst_ip like '".$net."%' and year='".$year."' and month='".$month."' and day='".$day."'  and proto!=17 and proto!=6 and proto!=1  group by dst_ip";
##############################################################
        }
    }

#    $query = "select day, sum(bytes) as bytes from new where src_ip like '".$net."%' and year='".$year."' and month='".$month."' group by day";
    $sent_query = $dbh->Query($querys);
#    $que = "select day, sum(bytes) as bytes from new where dst_ip like '".$net."%' and year='".$year."' and month='".$month."' group by day";
    $recv_query = $dbh->Query($queryr);

############################################################## Added by Nadir 02.08.2006
    $sent_tcp_query = $dbh->Query($querys_tcp);
    $recv_tcp_query = $dbh->Query($queryr_tcp);

    $sent_icmp_query = $dbh->Query($querys_icmp);
    $recv_icmp_query = $dbh->Query($queryr_icmp);

    $sent_udp_query = $dbh->Query($querys_udp);
    $recv_udp_query = $dbh->Query($queryr_udp);	

    $sent_other_query = $dbh->Query($querys_other);
    $recv_other_query = $dbh->Query($queryr_other);	
##############################################################

    $num = $sent_query->numrows;

    for($j = 0; $j < $num; $j++)
    {
        $recv_query->dataseek($j);
        $sent_query->dataseek($j);
        %sent = $sent_query->fetchhash;
        %recv = $recv_query->fetchhash;
        $info = $sent{first};
        $sent = sprintf("%.2f", $sent{second}/(1024*1024));
        $recv = sprintf("%.2f", $recv{second}/(1024*1024));
        $summ_sent += $sent;
        $summ_recv += $recv;
############################################################## Added by Nadir 02.08.2006

#####TCP
        $recv_tcp_query->dataseek($j);
        $sent_tcp_query->dataseek($j);
        %sent_tcp = $sent_tcp_query->fetchhash;
        %recv_tcp = $recv_tcp_query->fetchhash;

        $info_tcp = $sent{first};

        $sent_tcp = sprintf("%.2f", $sent_tcp{second}/(1024*1024));
        $recv_tcp = sprintf("%.2f", $recv_tcp{second}/(1024*1024));

        $summ_sent_tcp += $sent_tcp;
        $summ_recv_tcp += $recv_tcp;
####ICMP
        $recv_icmp_query->dataseek($j);
        $sent_icmp_query->dataseek($j);
        %sent_icmp = $sent_icmp_query->fetchhash;
        %recv_icmp = $recv_icmp_query->fetchhash;

        $info_icmp = $sent{first};

        $sent_icmp = sprintf("%.2f", $sent_icmp{second}/(1024*1024));
        $recv_icmp = sprintf("%.2f", $recv_icmp{second}/(1024*1024));

        $summ_sent_icmp += $sent_icmp;
        $summ_recv_icmp += $recv_icmp;

####UDP
        $recv_udp_query->dataseek($j);
        $sent_udp_query->dataseek($j);
        %sent_udp = $sent_udp_query->fetchhash;
        %recv_udp = $recv_udp_query->fetchhash;
        $info_udp = $sent{first};
        $sent_udp = sprintf("%.2f", $sent_udp{second}/(1024*1024));
        $recv_udp = sprintf("%.2f", $recv_udp{second}/(1024*1024));
        $summ_sent_udp += $sent_udp;
        $summ_recv_udp += $recv_udp;

####Other
        $recv_other_query->dataseek($j);
        $sent_other_query->dataseek($j);
        %sent_other = $sent_other_query->fetchhash;
        %recv_other = $recv_other_query->fetchhash;
        $info_other = $sent{first};
        $sent_other = sprintf("%.2f", $sent_other{second}/(1024*1024));
        $recv_other = sprintf("%.2f", $recv_other{second}/(1024*1024));
        $summ_sent_other += $sent_other;
        $summ_recv_other += $recv_other;

##############################################################

	

#       print "<TR BGCOLOR=\"Aqua\"><TD align=center><A HREF=\"?date=".$year."-".$month."-".$sent{day}."\">".$year."-".$month."-".$sent{day}."<\/A><\/TD><TD align=center>".$sent."<\/TD><TD align=center>".$recv."<\/TD><\/TR>\n";


            if(!($month))
            {
                # Only year
                $body .= "<TR BGCOLOR=\"Aqua\">\n";
		if($mode eq 'ip')
		{
		    if(($host = gethostbyaddr(inet_aton($info), AF_INET)) eq '') { $host = $info };
################################## NADIR 07.08.06
		    $body .= "<TD ALIGN=\"CENTER\"><A HREF=\"../more.php?month=".$month."&day=".$day."&year=".$year."&ip=".$info."\">".$host."<\/A><\/TD>\n";
###################################################
		}
		else
		{
		    $body .= "<TD ALIGN=\"CENTER\"><A HREF=\"?year=".$year."&month=".$info."\">".$month2dec{$info}."<\/A><\/TD>\n";
		}

		$body .= "<TD ALIGN=\"CENTER\">".$sent."<\/TD>\n";
		$body .= "<TD ALIGN=\"CENTER\">".$recv."<\/TD>\n";
		$body .= "<\/TR>\n";
            } else
            {
                if ($month && (!($day)))
                {
                    # Year and month
                    $body .= "<TR BGCOLOR=\"Aqua\">\n";
		    if($mode eq 'ip')
		    {
			if(($host = gethostbyaddr(inet_aton($info), AF_INET)) eq '') { $host = $info };
			$body .= "<TD ALIGN=\"CENTER\"><A HREF=\"?year=".$year."&month=".$month."&ip=".$info."\">".$host."<\/A><\/TD>\n";
		    }
		    else
		    {
			$body .= "<TD ALIGN=\"CENTER\"><A HREF=\"?year=".$year."&month=".$month."&day=".$info."\">".$info.".".$month.".".$year."<\/A><\/TD>\n";
		    }
		    
		    $body .= "<TD ALIGN=\"CENTER\">".$sent."<\/TD>\n";
		    $body .= "<TD ALIGN=\"CENTER\">".$recv."<\/TD>\n";
############################################################## Added by Nadir 02.08.2006
		    $body .= "<TD ALIGN=\"CENTER\"><a href=\"?year=$year&month=$month&stcp=$info\">".$sent_tcp."</a> / <a href=\"?year=$year&month=$month&rtcp=$info\">".$recv_tcp."</a><\/TD>\n";

		    $body .= "<TD ALIGN=\"CENTER\"><a href=\"?year=$year&month=$month&sudp=$info\">".$sent_udp."</a> / <a href=\"?year=$year&month=$month&rudp=$info\">".$recv_udp."</a><\/TD>\n";

		    $body .= "<TD ALIGN=\"CENTER\"><a href=\"?year=$year&month=$month&sicmp=$info\">".$sent_icmp."</a> / <a href=\"?year=$year&month=$month&ricmp=$info\">".$recv_icmp."</a><\/TD>\n";

		    $body .= "<TD ALIGN=\"CENTER\"><a href=\"?year=$year&month=$month&sother=$info\">".$sent_other."</a> /<a href=\"?year=$year&month=$month&rother=$info\">".$recv_other."</a><\/TD>\n";

##############################################################
		    $body .= "<\/TR>\n";
                } else {
                    # Year, month and day
		    if(($host = gethostbyaddr(inet_aton($info), AF_INET)) eq '') { $host = $info };
		    $body .= "<TR BGCOLOR=\"Aqua\">\n";
################################## NADIR  07.08.06
		    $body .= "<TD ALIGN=\"CENTER\"><A HREF=\"../more.php?month=".$month."&day=".$day."&year=".$year."&ip=".$info."\">".$host."<\/A><\/TD>\n";
##################################################
		    $body .= "<TD ALIGN=\"CENTER\">".$sent."<\/TD>\n";
		    $body .= "<TD ALIGN=\"CENTER\">".$recv."<\/TD>\n";
############################################################## Added by Nadir 02.08.2006
		    $body .= "<TD ALIGN=\"CENTER\"><a href=\"?year=$year&month=$month&day=$day&stcp=$host\">".$sent_tcp."</a> / <a href=\"?year=$year&month=$month&day=$day&rtcp=$host\">".$recv_tcp."</a><\/TD>\n";

		    $body .= "<TD ALIGN=\"CENTER\"><a href=\"?year=$year&month=$month&day=$day&sudp=$host\">".$sent_udp."</a> / <a href=\"?year=$year&month=$month&day=$day&rudp=$host\">".$recv_udp."</a><\/TD>\n";

		    $body .= "<TD ALIGN=\"CENTER\"><a href=\"?year=$year&month=$month&day=$day&sicmp=$host\">".$sent_icmp."</a> / <a href=\"?year=$year&month=$month&day=$day&ricmp=$host\">".$recv_icmp."</a><\/TD>\n";

		    $body .= "<TD ALIGN=\"CENTER\"><a href=\"?year=$year&month=$month&day=$day&sother=$host\">".$sent_other."</a> / <a href=\"?year=$year&month=$month&day=$day&rother=$host\">".$recv_other."</a><\/TD>\n";

##############################################################
		    $body .= "<\/TR>\n";
                }
            }
    }
    $body .= "<TR BGCOLOR=\"ffcc33\">\n";
    $body .= "<TD ALIGN=\"CENTER\">Total:<\/TD>\n";
    $body .= "<TD ALIGN=\"CENTER\">".$summ_sent."<\/TD>\n";
    $body .= "<TD ALIGN=\"CENTER\">".$summ_recv."<\/TD>\n";

############################################################## Added by Nadir 02.08.2006
    $body .= "<TD ALIGN=\"CENTER\">".$summ_sent_tcp." / ".$summ_recv_tcp."<\/TD>\n";
    $body .= "<TD ALIGN=\"CENTER\">".$summ_sent_udp." / ".$summ_recv_udp."<\/TD>\n";
    $body .= "<TD ALIGN=\"CENTER\">".$summ_sent_icmp." / ".$summ_recv_icmp."<\/TD>\n";
    $body .= "<TD ALIGN=\"CENTER\">".$summ_sent_other." / ".$summ_recv_other."<\/TD>\n";


##############################################################
    $body .= "<\/TR>\n";
    $body .= "<\/TABLE>\n";

############################################################## Added by Nadir 07.08.2006



##############################################################

    $body .= "<\/BODY><\/HTML>";

print $header;
print $body;


