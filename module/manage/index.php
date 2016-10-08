<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2009-01-15
* 작성자: 
* 설   명: 
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