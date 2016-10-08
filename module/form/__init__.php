<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-01-30
* 작성자: 김종태
* 설  명: 몰라임마~!
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');

$sql = "select str_title from TAB_MENU where num_oid = '$_OID' and num_cate = '$cate'";
$mtitle = $DB -> sqlFetchOne($sql);
$DOC_TITLE = "str:".$mtitle;



$skin = "basic";

$sql = "select * from TAB_FORM_CSS where num_oid = '$_OID' and num_code = '$code' ";
$fome = $DB -> sqlFetch($sql);
if($fome[end_date2]) {
$fome[end_date2] = $fome[end_date];	
}else{
$fome[end_date2] = mktime() + 86400;
}


if($fome[end_date])$fome[end_date] = date("Y-m-d",$fome[end_date]);
if($fome[dt_date])$fome[dt_date] = date("Y-m-d",$fome[dt_date]);

$tpl->assign($fome);
$tpl->assign(array('mk'=>mktime()));



?>