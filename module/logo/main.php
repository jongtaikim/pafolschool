<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-01-30
* 작성자: 김종태
* 설  명: 로고사이즈 거시기
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');
//모듈이 아닐경우는 지우세요
$tpl = &WebApp::singleton('Display');
$conf_main =  WebApp::getThemeConf('logo');
$conf =  WebApp::getThemeConf(_LAYOUT_R.'_logo');
$tpl->assign($conf);
$tpl->assign($conf_main);
//모듈이 아닐경우는 지우세요

$mcode = $param['mcode'];

//2008-04-17 종태 라이브러리를 위해서

$template = "/theme_lib/logo/noimg/attach.logo_no.htm";

if(_MCODE){
	$sql = "select str_title from tab_menu where num_oid = '"._OID."' and num_mcode = '".substr(_MCODE,0,2)."'";
	$menu_title= $DB -> sqlFetchOne($sql);
	$tpl->assign(array('menu_title'=>$menu_title));
}


$tpl->define('LOGO__',$template);
	
$content = $tpl->fetch('LOGO__');

echo $content;

?>