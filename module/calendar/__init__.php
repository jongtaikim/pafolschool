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
//==-- ȯ�溯�� ���� --==//
$PERM = &WebApp::singleton('Permission');
$tpl = &WebApp::singleton('Display');
//==-- ���̾ƿ� �����ϱ� --==//
if($PERM->check('main','calendar','m')  && $_SESSION[USERID] || $_SESSION[ADMIN]) {
$cal_admin="y";
$tpl->assign(array('cal_admin'=>'Y'));
}

//2009-06-27 ������Ʈ ȯ�漳��
include _DOC_ROOT.'/object/'.$mou_name.'/config.inc';
?>