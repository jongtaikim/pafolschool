<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2010-07-02
* 작성자: 김종태
* 설   명: 스마트에디터 바디
*****************************************************************
* 
*/

	$tpl->assign(array('mcodes'=>$_SESSION[doc_mcode],'host'=>HOST,'theme'=>_THEME));
	$tpl->setLayout('blank');
	$tpl->define("CONTENT", Display::getTemplate("editbody.htm"));
	

?>