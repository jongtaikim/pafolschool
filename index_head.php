<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2009-07-28
* �ۼ���: ������
* ��   ��: �ε��� �����μ���
*****************************************************************
* 
*/
$HTTP_HOST = $_SERVER[HTTP_HOST];
//2009-07-24 �ַ���� ���õ� ������
$domain_ = "cafe24.com"; 

if($HTTP_HOST != $_SERVER[SERVER_ADDR]) {
$domain_d = explode(".",$HTTP_HOST);
$HTTP_HOST = 	$domain_d[0].".".$domain_ ;
$SUB_HOST = $domain_d[0];
}else{
$SUB_HOST = $_SERVER[SERVER_ADDR];
}

$HOST = "pafolschool";

define('WEBAPP_RUNMODE_GLOBAL', 1);
define('WEBAPP_RUNMODE_FUNCTION', 2);

$CONF = @parse_ini_file("conf/global.conf.php",true);

$REQUEST_URI = getenv("REQUEST_URI");
$__ = parse_url($REQUEST_URI);

// 2007-04-16 REDIRECT POST��
if($requestReffer=="1"){ 
  $arr = get_defined_vars();
  $REQUEST_URI = getenv("HTTP_REFERER");
  $REQUEST_URI = str_replace("http://".$HTTP_HOST,"",$REQUEST_URI);
}
else{
  $REQUEST_URI = getenv("REQUEST_URI");

}

?>