<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: member/admin/crossuser.php
* 작성일: 2008-11-28
* 작성자: 이현민
* 설  명: 불량회원(ID, IP)관리
*****************************************************************
* 
*/

switch($REQUEST_METHOD) {
	case "GET":



		$tpl->assign(array(
		'searchkey'=>$searchkey,
		'searchvalue'=>$searchvalue,
		'ips'=>$ips
		));

		$tpl->setLayout('no4');
   		$tpl->define('CONTENT','html/member/admin/crossuser.htm');

	break;
	case "POST":
/*
		$serial = $DB->sqlFetchOne("SELECT max(NUM_SERIAL) + 1 FROM TAB_CROSSUSER WHERE NUM_OID = $_OID");
		if (!$serial) $serial = 1;

		$sql = "insert into TAB_CROSSUSER(num_oid, num_serial, str_chk, str_text, str_alert, num_date) values($_OID, $serial, '$str_chk', '$str_text', '$str_alert', '".mktime()."')";
		$DB->query($sql);
		$DB->commit();

		echo "<script>alert('저장되었습니다.');</script>";
		echo "<meta http-equiv='Refresh' Content=\"0; URL='/member.admin.crossuser'\">";
*/
	break;
}
?>
