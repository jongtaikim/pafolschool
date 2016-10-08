<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/party/admin/login.php
* 작성일: 2006-05-16
* 작성자: 이범민
* 설  명: 동아리 관리자 로그인
*****************************************************************
* 
*/



switch ($REQUEST_METHOD) {
	case "GET":
		$tpl->setLayout('p');
		$tpl->define('CONTENT','html/party/admin/login.htm');
	
		
		
		break;

	
	
	case "POST":
		$pass = trim($_POST['pass']);
		$DB = &WebApp::singleton('DB');
		$sql = "
			SELECT
				COUNT(*)
			FROM
				".TAB_PARTY."
			WHERE
				num_oid=$_OID AND num_pcode=$pcode AND str_pass='$pass'
		";
		if ($DB->sqlFetchOne($sql)) {
			$_SESSION['ADMIN_PARTY_'.$pcode] = true;
			WebApp::redirect('party.admin.frame?pcode='.$pcode);
		} else {
			WebApp::moveBack(_('Invalid Password'));
		}
}
?>