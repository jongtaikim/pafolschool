<?php
$code = 'popup';
$_POPUP = WebApp::getConf('popup');
$tpl = &WebApp::singleton('Display');
if(!$_POPUP[skin_name]) $_POPUP[skin_name] = "type01";
$tpl->assign($_POPUP);

//==-- ȯ�溯�� ���� --==//
$PERM = &WebApp::singleton('Permission');
//==-- ���̾ƿ� �����ϱ� --==//
if($PERM->check('main','popup','m')  && $_SESSION[USERID] || $_SESSION[ADMIN]) {
$pop_admin="y";
$tpl->assign(array('pop_admin'=>'Y'));
}
?>