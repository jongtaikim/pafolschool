<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/member/login.php
* 작성일: 2005-03-31
* 작성자: 거친마루
* 설  명: 회원 로그인
*****************************************************************
* 
*/
echo "here";
switch (REQUEST_METHOD) {
	case 'GET':
        $DOC_TITLE = 'str:로그인';
		$tpl->setLayout('@sub');
		$tpl->define('CONTENT', Display::getTemplate('member/login.htm'));
		$tpl->assign(array(
			'redir'		=>	$_REQUEST['redir']
		));
		break;
	case 'POST':
		$DB = &WebApp::singleton('DB');
        if(!$_POST['userid'] && !$_POST['passwd']) {
            $_SESSION['redir'] = getenv('HTTP_REFERER');
            WebApp::redirect('member.login');
        }
		$sql = "SELECT str_id,str_name,chr_mtype,num_fcode,num_auth FROM ".TAB_MEMBER." WHERE num_oid=$_OID AND str_id='".$_POST['userid']."' AND str_passwd='".$_POST['passwd']."'";
		if($data = $DB->sqlFetch($sql)) {
			$sql = "UPDATE ".TAB_MEMBER." SET num_login_cnt = num_login_cnt + 1 WHERE num_oid=$_OID AND str_id='".$_POST['userid']."'";
			$DB->query($sql);
			$DB->commit();

            if($data['num_auth']) {
                $mem_type = array($data['chr_mtype']);
                $sql = "SELECT str_group FROM ".TAB_GROUP_MEMBER." WHERE num_oid=$_OID AND str_id='".$_POST['userid']."'";
                if($gdata = $DB->sqlFetchAll($sql)) {
                    foreach($gdata as $_row) $mem_type[] = $_row['str_group'];
                }
           
                    setCookie('AUTH',true,0,'/','.'.HOST);
        			setCookie('USERID',$data['str_id'],0,'/','.'.HOST);
        
        			$_SESSION['AUTH'] = true;
        			$_SESSION['REMOTE_ADDR'] = getenv('REMOTE_ADDR');
        			$_SESSION['MEM_TYPE'] = $mem_type;
        			$_SESSION['USERID'] = $data['str_id'];
        			$_SESSION['NAME'] = $data['str_name'];
                    $_SESSION['CHR_MTYPE'] = $data['chr_mtype'];

					$USER_TYPE = $_SESSION['CHR_MTYPE'];
					//echo "USER_TYPE:$USER_TYPE";exit;
            if($data['num_fcode']) $_SESSION['FCODE'] = $data['num_fcode'];
			echo "<script type='text/javascript'>document.cookie = 'NAME=".$data['str_name']."';</script>";

			if($_SESSION['redir']) {
				$redir = $_SESSION['redir'];
				unset($_SESSION['redir']);
			} else {
				$redir = '/';
			}        
           
           
            } else {
                $mem_type = array('n');
                echo "
                <script>
                alert('회원승인 확인중입니다');
                history.go(-1);
                </script>
                ";
            
            }

			
			WebApp::redirect($redir);
		} else {
			WebApp::moveBack('아이디 또는 비밀번호가 일치하지 않습니다.');
		}
		break;
}

?>