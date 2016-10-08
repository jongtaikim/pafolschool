<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/member/crm/student.php
* 작성일: 2005-03-31
* 작성자: 거친마루
* 설  명: 학생회원 추가정보 입력창
*****************************************************************
* 
*/

switch (REQUEST_METHOD) {
	case 'GET':
		$tpl->setLayout('@sub');
		$tpl->define('CONTENT', Display::getTemplate('member/crm/student.htm'));
		break;
	case 'POST':
		break;
}
?>