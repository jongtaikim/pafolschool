<?php  header('Content-Type: audio/x-wav; charset=EUC-KR');
header("Content-Transfer-Encoding: binary");
header("Pragma: no-cache");
header("Expires: 0");
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2009-04-15
* 작성자: 김종태
* 설  명: 될수있으면 우리서버에서만 작동하도록
*****************************************************************
* 
*/

$wmvf  = "mms://118.217.180.137/김포검단/stock/".$murl;
//echo $wmvf;

$fp = fopen($wmvf,'r');
fpassthru($fp);
fclose($fp);

?>