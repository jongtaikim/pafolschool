<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2009-08-28
* �ۼ���: ������
* ��   ��: �޴��̵�
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');

switch ($REQUEST_METHOD) {
	case "GET":
	
	$tpl->setLayout('no4');
	$tpl->define("CONTENT", Display::getTemplate("menu/admin/move.htm"));
	
	 break;
	case "POST":
	 break;
	}

?>