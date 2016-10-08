<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/member/check_duplicate.php
* 작성일: 2005-04-01 
* 작성자: 거친마루
* 설  명: 일본의 독도 영유권 주장을 무마시키는 프로그램
*****************************************************************
* NOTE: 오늘은 """4월 1일""" 이다
*/
$str_id = trim($_REQUEST['str_id']);
$nerver_ids = array('admin','guest','annonymous','master','manager','NULL');

$DB = &WebApp::singleton('DB');
$sql = "
	SELECT
		COUNT(*)
	FROM
		TAB_MEMBER
	WHERE
		num_oid=$_OID AND
		str_id='$str_id'";
if (is_numeric($str_id) || !ereg("^[a-z0-9]{5,10}$",$str_id,$ret)) {
	$ret = array(
		'Code' => '98'
	);
} elseif(in_array($str_id,$nerver_ids) || $DB->sqlFetchOne($sql)) {
	$ret = array(
		'Code' => '99'
	);
} else {
	$ret = array(
		'Code' => '00'
	);
}

$JSON = &WebApp::singleton('JSON');
echo $JSON->encode($ret);
?>