<?php
$code = 'popup';
$_POPUP = WebApp::getConf('popup');
$tpl = &WebApp::singleton('Display');
if(!$_POPUP[skin_name]) $_POPUP[skin_name] = "type01";
$tpl->assign($_POPUP);

//==-- 환경변수 정의 --==//
$PERM = &WebApp::singleton('Permission');
//==-- 레이아웃 설정하기 --==//
if($PERM->check('main','popup','m')  && $_SESSION[USERID] || $_SESSION[ADMIN]) {
$pop_admin="y";
$tpl->assign(array('pop_admin'=>'Y'));
}
?>