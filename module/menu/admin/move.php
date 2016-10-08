<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2009-08-28
* 작성자: 김종태
* 설   명: 메뉴이동
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