<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/member/findid.php
* 작성일: 2005-11-29
* 작성자: 이범민
* 설  명: id, 비밀번호찾기
*****************************************************************
* 
*/

		if(!$mcode) $DOC_TITLE = "str:ID/비밀번호 찾기";
		$tpl->setLayout();
		$tpl->define('CONTENT',Display::getTemplate('member/findid.htm'));

?>