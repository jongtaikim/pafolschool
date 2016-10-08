<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-09-02
* 작성자: 김종태
* 설  명: 설정값 ajax로 리턴
*****************************************************************
* 
*/
//모듈이 아닐경우는 지우세요
$tpl = &WebApp::singleton('Display');
$conf =  WebApp::getThemeConf($layout_r.'_'.$mou_name);

if(!$conf[bbs_title]) {
	$DB = &WebApp::singleton('DB'); 
	$sql = "select str_title from TAB_MENU where num_oid = '$_OID' and num_mcode = '".$conf[bbs_code]."'";
	$conf[bbs_title] = $DB -> sqlFetchOne($sql);
}
echo $conf[type]."|".$conf[bbs_code]."|".$conf[bbs_title];


?>