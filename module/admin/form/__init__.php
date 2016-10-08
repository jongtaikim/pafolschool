<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: __init__.php
* 작성일: 2004-10-16
* 작성자: 이범민
* 설  명: 
*****************************************************************
* 
*/

// 2개의 홈페이지를 운영하는경우 회원정보 공유를 위해 oid 변경(2004-10-16)
if($member_alias_oid = WebApp::getConf("member_alias_oid")) {
	$oid = $member_alias_oid;
}

$oid = _OID;

?>