<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-01-30
* 작성자: 김종태
* 설  명: 몰라임마~!
*****************************************************************
* 
*/


$tpl->setLayout('admin');
$tpl->define("CONTENT",WebApp::getTemplate("popup/skin/".$skin."/view.htm"));
$tpl->assign(array(
	'content'=>$contentpv,
	'str_title'=>$title,
	'num_width'=>$width,
	'num_height'=>$height,
	));


?>