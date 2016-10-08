<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-01-30
* 작성자: 김종태
* 설  명: 몰라임마~!
*****************************************************************
* 
*/

//모듈이 아닐경우는 지우세요

switch ($REQUEST_METHOD) {
	case "GET":
	
	$tpl->setLayout('admin');
	$tpl->assign(array('text'=>"레이아웃이 적용되었습니다. 다음작업을 선택하세요."));
	
	
	$tpl->define("CONTENT", Display::getTemplate("attach/admin/select.htm"));
	
	 break;
	}

?>