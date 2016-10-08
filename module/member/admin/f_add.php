<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2009-08-24
* 작성자: 김종태
* 설   명: 바로가기 메뉴 등록
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