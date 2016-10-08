<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2009-07-31
* 작성자: 김종태
* 설   명: 가입완료!!
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');
	
	$DOC_TITLE = "str:회원가입완료";

	$tpl->assign(array('name'=>$name,'str_id'=>$str_id));
	
	$tpl->setLayout('@sub');
	$tpl->define("CONTENT", Display::getTemplate("member/join_step4.htm"));
	

?>