<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2009-08-17
* �ۼ���: ������
* ��   ��: �����ڸ޴���
*****************************************************************
* 
*/

switch ($REQUEST_METHOD) {
	case "GET":
	
	$tpl->setLayout('no3');
	$tpl->define("CONTENT", Display::getTemplate("admin/doc/admin_menu.htm"));
	
	 break;
	case "POST":
	 break;
	}

?>