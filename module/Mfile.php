<?php  header('Content-Type: audio/x-wav; charset=EUC-KR');
header("Content-Transfer-Encoding: binary");
header("Pragma: no-cache");
header("Expires: 0");
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2009-04-15
* �ۼ���: ������
* ��  ��: �ɼ������� �츮���������� �۵��ϵ���
*****************************************************************
* 
*/

$wmvf  = "mms://118.217.180.137/�����˴�/stock/".$murl;
echo $wmvf;
if($_SESSION[viewchk_]  == "Y") {

if($fp = fopen($wmvf,'r')){
echo "���⼺��";
fpassthru($fp);
fclose($fp);
}
}
?>