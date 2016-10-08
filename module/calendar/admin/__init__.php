<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: 
* 작성일: 
* 작성자: 이범민
* 설  명: 
*****************************************************************
* 
*/
//include_once "module/admin/__init__.php";

$tpl->setLayout('no4');
if($f) {
	$tpl->setLayout('admin');	
}

if($PERM->check('main','calendar','m')  && $_SESSION[USERID] || $_SESSION[ADMIN]) {
$cal_admin="y";
$tpl->assign(array('cal_admin'=>'Y'));
}else{
WebApp::moveBack('권한이 없습니다.');
exit;
}
?>