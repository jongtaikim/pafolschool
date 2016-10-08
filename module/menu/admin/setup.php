<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-09-02
* 작성자: 김종태
* 설  명: 매뉴설정
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');

switch ($REQUEST_METHOD) {
	case "GET":
	
	$tpl->setLayout('no');
	$tpl->define("CONTENT", Display::getTemplate("/menu/admin/setup.htm"));
	
	 break;
	case "POST":
	 break;
	}

?>