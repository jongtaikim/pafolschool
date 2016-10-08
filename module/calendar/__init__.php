<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* : __init__.php
* : 2005-03-17
* : 
*   : 
*****************************************************************
* 
*/
$code = 'calendar';
$skin = 'default';
$cache_file = 'hosts/'.HOST.'/inc.main.calendar.htm';
$conf = Display::getMainConf('calendar');

$mou_name = file_get_contents(dirname(__FILE__).'/name.inc');
//==-- 환경변수 정의 --==//
$PERM = &WebApp::singleton('Permission');
$tpl = &WebApp::singleton('Display');
//==-- 레이아웃 설정하기 --==//
if($PERM->check('main','calendar','m')  && $_SESSION[USERID] || $_SESSION[ADMIN]) {
$cal_admin="y";
$tpl->assign(array('cal_admin'=>'Y'));
}

//2009-06-27 오브젝트 환경설정
include _DOC_ROOT.'/object/'.$mou_name.'/config.inc';
?>