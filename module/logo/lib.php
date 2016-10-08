<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-04-17
* 작성자: 김종태
* 설  명: 로고라이브러리파일
*****************************************************************
* 
*/

$mou_name = "logo";
$DB = &WebApp::singleton("DB");
$tpl = &WebApp::singleton('Display');
$conf_main =  WebApp::getThemeConf($mou_name);
$conf =  WebApp::getThemeConf(_LAYOUT_R.'_'.$mou_name);

include $_SERVER["DOCUMENT_ROOT"].'/module/lib.php';

$tpl->assign($conf_main);
$tpl->assign($conf);

$template = "/theme_lib/logo/noimg/attach.logo_no.htm";

$sql = "select str_title from tab_menu where num_oid = '"._OID."' and num_mcode = '".substr($mcode,0,2)."'";

$menu_title= $DB -> sqlFetchOne($sql);
$tpl->assign(array('menu_title'=>$menu_title,'mcode'=>$mcode));


	$tpl->define('LOGO__',$template);
	
	$content = $tpl->fetch('LOGO__');

    echo $content;


	echo "|||logo";

?>
