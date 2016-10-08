<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2009-07-03
* 작성자: 김종태
* 설  명:  로그인 오브젝트
*****************************************************************
* 
*/



$DB = &WebApp::singleton('DB');
if(_OID == _AOID) {
	$template = "/theme_lib/login/attach.login_in_no.htm";	
	$sql = "select str_organ, num_oid from TAB_ORGAN where str_hometype = 'HOME'  ";
	$row = $DB -> sqlFetchAll($sql);
	$tpl->assign(array('organ_LIST'=>$row));
}

if($_SESSION[USERID]) {
	
	//2009-07-03 종태 카페 가입목록
	$sql = "select a.num_pcode, b.str_pname from TAB_PARTY_MEMBER a, TAB_PARTY b 
	where  

	a.num_oid = "._OID." and   
	a.num_oid = b.num_oid and
	a.num_pcode = b.num_pcode and a.str_id = '".$_SESSION[USERID]."'
	";

	$row = $DB -> sqlFetchAll($sql);
	$tpl->assign(array('pcode_LIST'=>$row));

	//2009-07-03 종태 쪽지수
	$sql = "
	SELECT COUNT(*) 
	FROM TAB_MEMO 
	WHERE num_oid = "._OID." and str_to_id = '".$_SESSION[USERID]."'
	AND str_save='N' AND str_to_del = 'N'
	";

	$total_memo = $DB->sqlFetchOne($sql);
	if(!$total_memo) $total_memo = 0;
	$tpl->assign(array('total_memo'=>$total_memo));

	$sql = "
	SELECT COUNT(*) 
	FROM TAB_MEMO 
	WHERE num_oid = "._OID." AND str_to_id = '".$_SESSION[USERID]."' 
	AND str_reading_date IS NULL AND str_save='N' AND str_to_del = 'N'
	";

	$new_memo = $DB->sqlFetchOne($sql);
	if(!$new_memo) $new_memo = 0;
	$tpl->assign(array('new_memo'=>$new_memo));

}


$sql = "select 
num_login_point, 
num_board_point, 
num_commint_point, 
num_repaly_point 

from TAB_MEMBER where num_oid = '"._OID."' and str_id  = '".$_SESSION['USERID']."' ";
$data = $DB -> sqlFetch($sql);

$my_point =  array_sum($data) + 0;
$tpl->assign(array('MY_POINT'=>$my_point));

$tpl->assign($setup);	


?>
