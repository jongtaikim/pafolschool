<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2009-08-31
* 작성자: 김종태
* 설   명: 메뉴카데고리 번호 얻기
*****************************************************************
* 
*/

if(_MCODE || $mcode){
$DB = &WebApp::singleton('DB');
$sql = "select NUM_CATE from TAB_MENU where num_oid = "._OID." and num_mcode =  "._MCODE." ";
$cate = $DB -> sqlFetchOne($sql);
$tpl = &WebApp::singleton('Display'); 
$tpl->assign(array('cate'=>$cate));

}



?>