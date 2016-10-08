<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2012-06-17
* 작성자: 김종태
* 설   명: 가격업데이트
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');

list($ccode,$serial) = explode("|",$select_ccode);

$sql = "select num_price from TAB_CAMP where num_oid = '$_OID' and num_ccode = '".$ccode."' and num_serial = '".$serial."' ";
echo $DB -> sqlFetchOne($sql);



?>