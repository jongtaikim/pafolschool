<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2009-08-24
* �ۼ���: ������
* ��   ��: �ٷΰ��� �޴� ���
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');


switch ($REQUEST_METHOD) {
	case "GET":
	
	$tpl->setLayout('no3');
	$tpl->define("CONTENT", Display::getTemplate("menu/admin/f_add.htm"));
	
	 break;
	case "POST":
	 break;
	}

?>