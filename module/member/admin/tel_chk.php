<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-10-27
* 작성자: 김종태
* 설  명:  핸드폰 인증
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');

$sql = "select count(*) from TAB_HANDPHONE_IDX where num_oid = '$_OID' and str_hp = '".$str_hp."'";
$countr = $DB -> sqlFetchOne($sql);

if($countr > 0) {
	echo "N|N";
}else{
	$mk = substr(md5($str_hp),0,5);
	echo "Y|".$mk;
}

?>