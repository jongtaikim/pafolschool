<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2009-01-15
* 작성자: 김종태
* 설   명: 위젯기본파일
*****************************************************************
* 
*/
$mou_name =  $key;

$tpl = &WebApp::singleton('Display');
$conf_main =  WebApp::getThemeConf($mou_name);
$conf =  WebApp::getThemeConf($r_layout.'_'.$mou_name);

include $_SERVER["DOCUMENT_ROOT"].'/module/lib.php';
$conf[skin] = $theme;

$tpl->assign($conf);
$tpl->assign($conf_main);

	//2008-04-17 종태 라이브러리를 위해서
	if(is_file(_DOC_ROOT."/object/".$mou_name."/".$conf[skin].".html")) {
	$template = "/object/".$mou_name."/".$conf[skin].".html";		
	}else{
	$template = "/object/".$mou_name."/object.html";
	}

	$tpl->define($mou_name.'_W_',$template);


	include 'module.php';


	$content = $tpl->fetch($mou_name.'_W_');
	

	

    echo $content;
	echo "|||".$mou_name;

?>
