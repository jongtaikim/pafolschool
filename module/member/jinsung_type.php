<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-01-30
* 작성자: 김종태
* 설  명: 사이트 신청
*****************************************************************
* 
*/
$DB = &WebApp::singleton("DB");
switch ($REQUEST_METHOD) {
	case "GET":
	$DOC_TITLE = "str:회원형태 선택";

	$tpl->setLayout('@sub');
	$tpl->define("CONTENT", Display::getTemplate("member/jinsung_type.htm"));
	
	 break;
	}

?>
