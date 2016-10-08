<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: member/admin/crossuser.php
* 작성일: 2008-11-28
* 작성자: 이현민
* 설  명: 불량회원(IP)관리
*****************************************************************
* 
*/

switch($REQUEST_METHOD) {
	case "GET":
		
		if(!$id){
			WebApp::moveBack("Error!!!");
			exit;
		}

		$sql = "delete from TAB_CROSSUSER where num_oid=$_OID and num_serial=$id";
		if($DB->query($sql)){
			$DB->commit();

			echo "<script>alert('삭제되었습니다.');</script>";
			echo "<meta http-equiv='Refresh' Content=\"0; URL='/member.admin.crossuser'\">";
		}else{
			WebApp::moveBack("Error!!!");
		}


	break;
	case "POST":

	break;
}
?>
