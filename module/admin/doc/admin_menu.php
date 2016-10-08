<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2009-08-17
* 작성자: 김종태
* 설   명: 관리자메뉴얼
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