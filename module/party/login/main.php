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
	
	//2008-04-17 종태 라이브러리를 위해서
	if(is_file(_DOC_ROOT."/object/".$mou_name."/".$conf[skin].".html")) {
	$template = "/object/".$mou_name."/".$conf[skin].".html";		
	}else{
	$template = "/object/".$mou_name."/object.html";
	}
 
   if(_LAYOUT_R =="sub") {
	$template = "/object/".$mou_name."/object_sub.html";
   	 $type_number = $type_number+0;
	 if($type_number <10) 	$type_number = "0".$type_number;
	 $conf[skin] = "type".$type_number;
	 $tpl->assign($conf);
   }
	
	if($param[skin]) {
	$conf[skin] = $param[skin];
	 $tpl->assign($conf);
	}

   $tpl->define($mou_name.'_W_',$template);
	


	// 소스 입력부분


	include 'module.php';


	// 소스입력끝



	$content = $tpl->fetch($mou_name.'_W_');
    echo $content;

?>
