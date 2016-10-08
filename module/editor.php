<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2009-08-26
* 작성자: 김종태
* 설   명: ㅋㅋㅋ
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