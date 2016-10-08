<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-01-30
* 작성자: 김종태
* 설  명: 몰라임마~!
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');
	
	$tpl->setLayout('@sub');
	$tpl->define("CONTENT", Display::getTemplate("member/join_step.htm"));
	$tpl->assign(array(
		'return'=>"N",
		'str_id'=>$str_id,

		));
	
?>