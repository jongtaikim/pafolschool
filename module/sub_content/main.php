<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2009-01-15
* 작성자: 김종태
* 설   명: 위젯기본파일
*****************************************************************
* 
*/

$tpl = &WebApp::singleton('Display');
$conf_main =  WebApp::getThemeConf($mou_name);
$conf =  WebApp::getThemeConf(_LAYOUT_R.'_'.$mou_name);
$tpl->assign($conf);
$tpl->assign($conf_main);

include $_SERVER["DOCUMENT_ROOT"].'/module/wmain.php';
	

   $template = "/object/sub_content.htm";

   $tpl->define($mou_name.'_W_',$template);
	


	// 소스 입력부분


	//include 'module.php';


	// 소스입력끝



	$content = $tpl->fetch($mou_name.'_W_');
    echo $content;

?>
