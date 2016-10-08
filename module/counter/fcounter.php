<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: counter/fcounter.php
* 작성일: 2006-03-02
* 작성자: 이범민
* 설  명: 파일 카운터
*****************************************************************
* 사용법 :
<script type="text/javascript" src="counter.fcounter?var_today=COUNTER_TODAY&var_total=COUNTER_TOTAL"></script>
오늘 : <script type="text/javascript">document.write(COUNTER_TODAY);</script><br>
전체 : <script type="text/javascript">document.write(COUNTER_TOTAL);</script><br>
*/
	

function counter_add_remote_addr($file, $ip) {
    $fp = fopen($file,'a+');
    fwrite($fp,$ip."\n");
    fclose($fp);
    chmod($file,0777);
}
function counter_ip_trim(&$ip) {
    $ip = trim($ip);
}
if(!$var_today = $_REQUEST['var_today']) $var_today = 'COUNTER_TODAY';
if(!$var_total = $_REQUEST['var_total']) $var_total = 'COUNTER_TOTAL';
$total_file = 'hosts/'.HOST.'/files/counter_total.txt';
$remote_addr_file = 'hosts/'.HOST.'/files/counter_ips.txt';
$ip = getenv('REMOTE_ADDR');
if(filemtime($remote_addr_file) < strtotime(date('Y-m-d'))) {
    if(!is_file($total_file)) {
        $total = 0;
    } else {
        $today = @count(@file($remote_addr_file));
        $total = (int)@file_get_contents($total_file) + $today;
    }
    
    $fp = fopen($total_file,'w');
    fwrite($fp, $total);
    fclose($today);
    chmod($total_file,0777);
    @unlink($remote_addr_file);
}

if (!is_file($remote_addr_file)) {
    $today = 1;
    counter_add_remote_addr($remote_addr_file, $ip);
} else {
    array_walk($file = @file($remote_addr_file),'counter_ip_trim');
    if (!is_array($file)) {
        $today = 1;
        counter_add_remote_addr($remote_addr_file, $ip);
    } elseif (!in_array($ip,$file)) {
        $today = count($file);
        counter_add_remote_addr($remote_addr_file, $ip);
    } else {
        $today = count($file);
    }
}

$y_total = (int)@file_get_contents($total_file);
$total = $y_total + $today;

echo 'var '.$var_today.' = '.$today.";\n";
echo 'var '.$var_total.' = '.$total.";\n";
exit;

?>