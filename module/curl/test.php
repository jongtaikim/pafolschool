<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2008-01-30
* �ۼ���: ������
* ��  ��: �����Ӹ�~!
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');
$curl = &WebApp::singleton('Curl');

$curl->url="http://m.naver.com";
$res = $curl->curl_login();

echo $res;

?>