<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: lib/class.BSAdminAuth.php
* �ۼ���: 2005-09-08
* �ۼ���: �̹���
* ��  ��: �����ڱ��� üũ
*****************************************************************
* 
*/
class AdminAuth {
	function AdminAuth() {}

	// ���� üũ
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
					WebApp::moveBack('���� ������ �����ϴ�.');
					break;
				case 'close':
					WebApp::closeWin('���� ������ �����ϴ�.');
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