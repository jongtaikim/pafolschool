<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: member/joined.php
* 작성일: 2005-11-28
* 작성자: 이범민
* 설  명: 회원가입 확인 페이지
*****************************************************************
* 
*/
switch($REQUEST_METHOD) {
	case "GET":
		$tpl->setLayout('@sub2');
		$tpl->define('CONTENT',Display::getTemplate('member/joined.htm'));
	break;
	case "POST":
		
	break;
}
?>