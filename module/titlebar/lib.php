<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2008-04-17
* �ۼ���: ������
* ��  ��: ī���� ���̺귯������
*****************************************************************
* 
*/

$mou_name = "titlebar";


$tpl = &WebApp::singleton('Display');
$conf_main =  WebApp::getThemeConf($mou_name);
$conf =  WebApp::getThemeConf(_LAYOUT_R.'_'.$mou_name);

include $_SERVER["DOCUMENT_ROOT"].'/module/lib.php';

$tpl->assign($conf);
$tpl->assign($conf_main);

$conf[height] = 10;
 $tpl->assign(array('title_text'=>"����Ÿ��Ʋ��"));



	$template = "/theme_lib/".$mou_name."/".$theme."/attach.".$mou_name."_no.htm";
	$tpl->define('TITLEBAR__',$template);
	
	$content = $tpl->fetch('TITLEBAR__');

    echo $content;

	echo "|||titlebar";

?>
