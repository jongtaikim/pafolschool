<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2009-01-15
* �ۼ���: 
* ��   ��: 
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');

switch ($REQUEST_METHOD) {
	case "GET":
	

	$tpl->setLayout();
	$tpl->define("CONTENT", Display::getTemplate(".htm"));
	
	 break;
	case "POST":
	 break;
	}

?>