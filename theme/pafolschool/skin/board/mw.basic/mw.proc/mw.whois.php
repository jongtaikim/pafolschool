<?
/**
 * Bechu-Basic Skin for Gnuboard4
 *
 * Copyright (c) 2008 Choi Jae-Young <www.miwit.com>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

include_once("_common.php");
include_once("$g4[path]/head.sub.php");

if ($is_admin != "super") 
    alert_close("최고관리자만 접근 가능합니다.");

if (!$ip)
    alert_close("IP 주소가 없습니다.");

$query = $ip;

$mode = 'KLOOKUP';

$server = "whois.nic.or.kr";
$ser_name = "KRNIC";

$fp = fsockopen($server,43);
if(!$fp)
{
    alert_close("WHOIS 서버에 접속할 수 없습니다.");
}
else
{
    if(!ereg($query, "\n$")) {
	$oldquery=$query;
	$query .= "\n";
    }
    fputs($fp,"$query");
    $i=0;
    while(!feof($fp)) {
	$result[$i]=fgets($fp,80);
	$i++; 
    }
    fclose($fp);
    ?>
    <div style='padding:10px'>

	<hr><center><h3> <?=$oldquery?> 에 대한 <?=$ser_name?>  WHOIS 검색결과 입니다.  </h3></center>  
	<?
	for($j=0 ; $j<count($result) ; $j++)
	{ 
	    echo $result[$j].'<br>';
	}
	?>
	<div style='text-align:center'><input type=button value="닫     기" onclick="self.close();"></div>
	<HR>

    </div>
    <?
}  

include_once("$g4[path]/tail.sub.php");
?>
