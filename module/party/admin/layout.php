<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2009-07-20
* 작성자: 김종태
* 설   명: 카페 레이아웃관리
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');


switch ($REQUEST_METHOD) {
	case "GET":
	
	$tpl->setLayout('admin');
	$tpl->define("CONTENT", Display::getTemplate("party/admin/layout.htm"));
	
	 break;
	case "POST":
	 break;
	}

?>