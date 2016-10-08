<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/party/admin/__init__.php
* 작성일: 2006-05-16
* 작성자: 이범민
* 설  명: 
*****************************************************************
* 
*/

if(!$_SESSION[CAFE_ADMIN] && !$_SESSION[CAFE_ADMIN_sub]){
	WebApp::moveBack('권한이 없습니다.');
}
?>