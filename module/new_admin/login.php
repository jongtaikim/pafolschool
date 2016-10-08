<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* : login.php
* : 2005-02-14
* : 
*   : 
*****************************************************************
* 
*/
switch ($REQUEST_METHOD) {
	case "GET":
		$tpl->setLayout('@sub');
		if($_SERVER[HTTP_HOST] == "samples.iknock.co.kr") {
		$tpl->define('CONTENT',WebApp::getTemplate('admin/login_s.htm'));			
		}else{
				$tpl->define('CONTENT',WebApp::getTemplate('admin/login.htm'));
		}

		break;
	case "POST":
		$password = trim($_POST['password']);
		$DB = &WebApp::singleton('DB');
		$sql = "
			SELECT
				COUNT(*)
			FROM
				TAB_ORGAN
			WHERE
				num_oid=$_OID AND str_password='$password'
		";
		if ($DB->sqlFetchOne($sql)) {
			$_SESSION['ADMIN'] = true;
            $_SESSION['MEM_TYPE'] = "t";
			if($redir = $_SESSION['redir']) {
                unset($_SESSION['redir']);
                WebApp::redirect($redir);
            } else {
    			WebApp::redirect('admin.main');
            }
		} else {
			WebApp::raiseError(_('Invalid Password'));
		}
}
?>
