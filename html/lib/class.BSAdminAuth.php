<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: lib/class.BSAdminAuth.php
* 작성일: 2005-09-08
* 작성자: 이범민
* 설  명: 관리자권한 체크
*****************************************************************
* 
*/
class AdminAuth {
	function AdminAuth() {}

	// 권한 체크
	function check($part = 'home') {
		if (!$_SESSION['ADMIN'] || !is_array($_SESSION['ADMIN'])) {
			WebApp::redirect('bs.admin.login?redir='.base64_encode(REQUEST_URI));
		}
		return (in_array($_SESSION['ADMIN'],$part) || in_array($_SESSION['ADMIN'],'super'));
	}

	function apply($part = 'home',$method = 'back') {// method = 'close','back'
		if (!BSAdminAuth::check($part)) {
			switch($method) {
				case 'back':
					WebApp::moveBack('접근 권한이 없습니다.');
					break;
				case 'close':
					WebApp::closeWin('접근 권한이 없습니다.');
					break;
			}
			return false;
		}
		return true;
	}

	function login($id,$pass) {
		$DB = &WebApp::singleton('DB');
		$sql = "SELECT str_name,str_part FROM ".BS_ADMIN_ACCOUNT." WHERE num_oid="._OID." AND str_id='$id' AND str_pass='$pass'";
		if (!$data = $DB->sqlFetch($sql)) return false;
		setCookie('ADMIN_NAME',$data['str_name'],0,'/','.'.HOST);
		$_SESSION['ADMIN'] = explode(',',$data['str_part']);
		return true;
	}

	function logout() {
		setCookie('ADMIN_NAME','',-3600,'/','.'.HOST);
		$_SESSION['ADMIN'] = false;
		return true;
	}
}
?>