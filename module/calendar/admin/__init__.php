<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: 
* �ۼ���: 
* �ۼ���: �̹���
* ��  ��: 
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
WebApp::moveBack('������ �����ϴ�.');
exit;
}
?>