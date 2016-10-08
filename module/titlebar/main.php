<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-04-17
* 작성자: 김종태
* 설  명: 카운터 라이브러리파일
*****************************************************************
* 
*/

$mou_name = "titlebar";
$tpl = &WebApp::singleton('Display');
$conf_main =  WebApp::getThemeConf($mou_name);
$conf =  WebApp::getThemeConf(_LAYOUT_R.'_'.$mou_name);
$FH = &WebApp::singleton('FileHost','menu_top',$mcode);
$tpl->assign($conf);
$tpl->assign($conf_main);


	$template = $param['template'];

	$tpl->define('TITLEBAR__',$template);
	
	$content = $tpl->fetch('TITLEBAR__');
	$DB = &WebApp::singleton('DB');
	$sql = "select str_text3 from TAB_TITLE_DOC where num_oid = "._OID." and num_mcode = "._MCODE." and num_css = "._CSS."";
	$str_text_a = $DB -> sqlFetchOne($sql);
	
	echo $content;
	echo $FH->set_content($str_text_a);






?>

