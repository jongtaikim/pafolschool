<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: __init__.php
* 작성일: 2009-07-09
* 작성자: 김종태
* 설  명: 
*****************************************************************
* 
*/
 $URL = &WebApp::singleton('WebAppURL');
 $tpl = &WebApp::singleton('Display');

$TITLES = array('honor'=>'명예의전당','know'=>'지식과상식');
if(!$code = $_REQUEST['code']) $code = $param['code'];
//if(!$code || !array_key_exists($code,$TITLES)) WebApp::raiseError('잘못된 요청입니다.');
if(!$code) $code = "honor";
$tpl_file = "tpl.news.$code.htm";
$cache_file = 'hosts/'.HOST.'/inc.main.news.'.$code.'.htm';
$conf = Display::getMainConf('news_'.$code);

$skin = $conf['skin'] ? $conf['skin'] : 'basic';
$title = $conf['title'] ? $conf['title'] : $TITLES[$code];


//$PERM = &WebApp::singleton('Permission');

$tpl->assign(array('code'=> $code));
include _DOC_ROOT.'/module/file.php';



//==-- 템플릿 기능버튼 링크 정의 --==//
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