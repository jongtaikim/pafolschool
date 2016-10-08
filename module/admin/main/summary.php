<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/admin/main/compose.php
* 작성일: 2006-01-16
* 작성자: 서종석
* 설  명: 메인화면
*****************************************************************
* 
*/
switch (REQUEST_METHOD) {
	case 'GET':
		$tpl->setLayout('admin');
		$tpl->define('CONTENT', WebApp::getTemplate('admin/main/summary.htm'));
		break;
	case 'POST':
		break;
}

?>