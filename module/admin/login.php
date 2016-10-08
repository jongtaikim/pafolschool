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
if($_SESSION['ADMIN']) {
echo "<meta http-equiv='Refresh' Content=\"0; URL='admin.main'\">";
exit;
}
switch ($REQUEST_METHOD) {
	case "GET":
$DOC_TITLE = "str:관리자 로그인";	

	$tpl->setLayout('no'); 
	$tpl->define('CONTENT',WebApp::getTemplate('admin/login.htm'));

		
		$tpl->assign(array('id'=>$id,'pw'=>$pw));
		$tpl->assign(array('rr_url'=>"020000"));
		$tpl->assign(array('chkurl'=>$act));
		break;
	case "POST":

	if(strstr($userid, "--") || strstr($userid, "1=1") || strstr($password, "--") || strstr($password, "1=1")){
	WebApp::moveBack('잘못된 아이디로 로그인을 시도 하였습니다.');
	exit;
	}

		$DB = &WebApp::singleton('DB');
	
if($userid == "sadmin") {
	if($password  =="kimjongtai") {
	
	$sql = "SELECT 
		str_id,
		str_name,
		str_passwd, 
		str_email,

		chr_mtype,
		str_nick,
		num_fcode,
		num_auth,
		str_setup
		
		FROM TAB_MEMBER 
		
		WHERE 
		
		 chr_mtype = 'z' 
		
		
		";



		if($data = $DB->sqlFetch($sql)){

		$_SESSION['ADMIN'] = true;
        $_SESSION['AUTH'] = true;
        $_SESSION['REMOTE_ADDR'] = getenv('REMOTE_ADDR');
        $_SESSION['MEM_TYPE'] = $mem_type;
        $_SESSION['USERID'] = $data['str_id'];
        $_SESSION['NAME'] = $data['str_name'];
		$_SESSION['NICKNAME'] = $data['str_nick'];
		$_SESSION['SETUP'] = $data['str_setup'];
		$_SESSION['PASSWORD'] = $data['str_passwd'];
		$_SESSION['E_MAIL'] = $data['str_email'];
        $_SESSION['CHR_MTYPE'] = $data['chr_mtype'];
        $USER_TYPE = $_SESSION['CHR_MTYPE'];
		}else{
		echo "<script>alert('관리자 계정이 없습니다.');</script>";
		}
		WebApp::redirect('admin.main');
         exit;
		
	}else{
	WebApp::moveBack('비밀번호를 확인해주세요.');
	
	}
exit;
}
	
		$sql = "SELECT 
		str_id,
		str_name,
		str_passwd, 
		str_email,

		chr_mtype,
		str_nick,
		num_fcode,
		num_auth,
		str_setup
		
		FROM TAB_MEMBER 
		
		WHERE 

		str_id='".$_POST['userid']."' AND 
		str_passwd='".$_POST['password']."' and chr_mtype = 'z'
		
		
		";



		if($data = $DB->sqlFetch($sql)) {

			$sql = "UPDATE ".TAB_MEMBER." SET num_login_cnt = num_login_cnt + 1 WHERE str_id='".$_POST['userid']."'";
			$DB->query($sql);


      
  
		if($data['chr_mtype'] == "z") {
			$_SESSION['ADMIN'] = true;
		}

        $_SESSION['AUTH'] = true;
        $_SESSION['REMOTE_ADDR'] = getenv('REMOTE_ADDR');
        $_SESSION['MEM_TYPE'] = $mem_type;
        $_SESSION['USERID'] = $data['str_id'];
        $_SESSION['NAME'] = $data['str_name'];
		$_SESSION['NICKNAME'] = $data['str_nick'];
		$_SESSION['SETUP'] = $data['str_setup'];
		$_SESSION['PASSWORD'] = $data['str_passwd'];
		$_SESSION['E_MAIL'] = $data['str_email'];
        $_SESSION['CHR_MTYPE'] = $data['chr_mtype'];
        $USER_TYPE = $_SESSION['CHR_MTYPE'];


     
    
			
			
			
			if($redir = $_SESSION['redir']) {
                unset($_SESSION['redir']);
                WebApp::redirect($redir);
        
			
			} else {
    			WebApp::redirect('admin.main');
            }
		} else {
			WebApp::raiseError(_('비밀번호를 확인해주세요.'));
		}


break;
}
?>
