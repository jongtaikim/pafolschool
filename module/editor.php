<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2009-08-26
* �ۼ���: ������
* ��   ��: ������
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');

switch ($REQUEST_METHOD) {
	case "GET":
	
	
	$tpl->setLayout('admin_xhtml');
	$tpl->define("CONTENT", Display::getTemplate("editor.htm"));
	
	 break;
	case "POST":

		

	 break;
	}

?>