<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2008-03-31
* �ۼ���: ������
* ��  ��: ��⵵��� �˾�
*****************************************************************
* 
*/
$DB = &WebApp::singleton("DB");
switch ($REQUEST_METHOD) {
	case "GET":
	
	$tpl->setLayout('admin');
	$tpl->define("CONTENT", Display::getTemplate("admin/tv.htm"));
	
	 break;
	}
 ?>