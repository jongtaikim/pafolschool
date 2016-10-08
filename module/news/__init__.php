<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: __init__.php
* �ۼ���: 2009-07-09
* �ۼ���: ������
* ��  ��: 
*****************************************************************
* 
*/
 $URL = &WebApp::singleton('WebAppURL');
 $tpl = &WebApp::singleton('Display');

$TITLES = array('honor'=>'��������','know'=>'���İ����');
if(!$code = $_REQUEST['code']) $code = $param['code'];
//if(!$code || !array_key_exists($code,$TITLES)) WebApp::raiseError('�߸��� ��û�Դϴ�.');
if(!$code) $code = "honor";
$tpl_file = "tpl.news.$code.htm";
$cache_file = 'hosts/'.HOST.'/inc.main.news.'.$code.'.htm';
$conf = Display::getMainConf('news_'.$code);

$skin = $conf['skin'] ? $conf['skin'] : 'basic';
$title = $conf['title'] ? $conf['title'] : $TITLES[$code];


//$PERM = &WebApp::singleton('Permission');

$tpl->assign(array('code'=> $code));
include _DOC_ROOT.'/module/file.php';



//==-- ���ø� ��ɹ�ư ��ũ ���� --==//
$modifylink = $URL->setVar('act','.write');
$replylink = $URL->setVar('act','.reply');
$deletelink = $URL->setVar('act','.delete');

$URL->delVar('id','num');
$writelink = $URL->setVar('act','.write');
$listlink = $URL->setVar('act','.list');
$tpl->assign(array(
	'modifylink' => $modifylink,
	'replylink' => $replylink,
	'deletelink' => $deletelink,
	'writelink' => $writelink,
	'listlink' => $listlink,
	'listnum'=>$_conf['option']['listnum']
));


if($mode =="admin") {
$tpl->setLayout('no3');
}else{
$tpl->setLayout('@sub');
}


if(!$mode) $mode = "order";
$tpl->assign(array('mode'=>$mode));

$tpl->define("TOP_TAB", '/html/news/top_tab.htm');
?>