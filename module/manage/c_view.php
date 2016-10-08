<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-03-25
* 작성자: 김종태
* 설  명: 스킨 포트폴리오 리스트
*****************************************************************
* 
*/
$DB = &WebApp::singleton("DB");
switch ($REQUEST_METHOD) {
	case "GET":
	
$DOC_TITLE = "str:템플릿 디자인";

	$tpl->setLayout('@sub');
	$tpl->define("CONTENT", "/module/manage/c_view.htm");
	 break;
	case "POST":
	 break;
	}

?>