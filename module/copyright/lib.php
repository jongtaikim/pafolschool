<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-04-17
* 작성자: 김종태
* 설  명: 카운터 라이브러리파일
*****************************************************************
* 
*/

$mou_name = "copyright";

$tpl = &WebApp::singleton('Display');
$conf_main =  WebApp::getThemeConf($mou_name);
$conf =  WebApp::getThemeConf(_LAYOUT_R.'_'.$mou_name);

include $_SERVER["DOCUMENT_ROOT"].'/module/lib.php';

$tpl->assign($conf);
$tpl->assign($conf_main);


	$template = "/theme_lib/".$mou_name."/".$theme."/attach.".$mou_name."_no.htm";
	$tpl->define('LOGIN_',$template);
	
$DB = &WebApp::singleton("DB");
$data2 = $DB->sqlFetch("SELECT * FROM ".TAB_ORGAN." WHERE NUM_OID="._OID);

	

	$tpl->define('COPYRIGHT_',$template);
	
	$tpl->assign($data2);

	$content = $tpl->fetch('COPYRIGHT_'.$type);


    echo $content;
	echo "|||copyright";

?>
