<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2009-08-12
* 작성자: 김종태
* 설   명: 회원정책
*****************************************************************
* 
*/

switch ($REQUEST_METHOD) {
	case "GET":
	
	$tpl->setLayout('no3');
	$tpl->define("CONTENT", Display::getTemplate("member/info_doc.htm"));
	
	 break;
	case "POST":
	 break;
	}

?>