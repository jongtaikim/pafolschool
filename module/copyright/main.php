<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2008-04-17
* �ۼ���: ������
* ��  ��: 
*****************************************************************
* 
*/

$mou_name = "copyright";
$tpl = &WebApp::singleton('Display');
$conf_main =  WebApp::getThemeConf($mou_name);
$conf =  WebApp::getThemeConf(_LAYOUT_R.'_'.$mou_name);
$tpl->assign($conf);
$tpl->assign($conf_main);



$tpl = &WebApp::singleton('Display');


	
//2008-04-17 ���� ���̺귯���� ���ؼ�

if($conf['skin']) $theme_name = $conf['skin']; 
elseif($conf_main['skin']) $theme_name = $conf_main['skin'];
else $theme_name = "simple"; //��Ų�� ������� �⺻

	$template = $param['template'];
    if ($theme_name) $template = "/theme_lib/".$mou_name."/".$theme_name."/attach.".$mou_name."_no.htm";

$DB = &WebApp::singleton("DB");
$data2 = $DB->sqlFetch("SELECT * FROM ".TAB_ORGAN." WHERE NUM_OID="._OID);

	

	$tpl->define('COPYRIGHT__',$template);
	
	$tpl->assign($data2);

	$content = $tpl->fetch('COPYRIGHT__'.$type);
	

    echo $content;

?>
