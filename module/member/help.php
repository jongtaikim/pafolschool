<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-01-30
* 작성자: 김종태
* 설  명: 몰라임마~!
*****************************************************************
* 
*/

$tpl->setLayout('admin_xhtml');

switch ($mode) {
	case "1":

	$tpl->define("CONTENT", Display::getTemplate("member/joinHelpPage.html"));
	
	 break;
	case "2":
	 break;
	}

?>