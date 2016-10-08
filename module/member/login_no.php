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


switch (REQUEST_METHOD) {
	case 'GET':
        $DOC_TITLE = 'str:로그인';
		$tpl->setLayout('admin');
		$tpl->define('CONTENT', Display::getTemplate('member/login.htm'));
		$tpl->assign(array(
			'redir'		=>	$_REQUEST['redir']
		));
		break;
	case 'POST':
		$DB = &WebApp::singleton('DB');
   if(!$userid && !$passwd) {
        $_SESSION['redir'] = getenv('HTTP_REFERER');
        WebApp::redirect('member.login');
    }
		$sql = "SELECT str_id,str_name,chr_mtype,num_fcode,num_auth, str_passwd, str_email, str_group, str_state, num_grade, num_hid, str_icon FROM ".TAB_MEMBER." WHERE num_oid=$_OID AND str_id='".$userid."' AND str_passwd='".$passwd."'";

		if($data = $DB->sqlFetch($sql)) {
			$sql = "UPDATE ".TAB_MEMBER." SET num_login_cnt = num_login_cnt + 1 WHERE num_oid=$_OID AND str_id='".$userid."'";
			$DB->query($sql);
			$DB->commit();

      if($data['num_auth']) {
        $mem_type = array($data['chr_mtype']);
        $sql = "SELECT str_group FROM ".TAB_GROUP_MEMBER." WHERE num_oid=$_OID AND str_id='".$userid."'";
        if($gdata = $DB->sqlFetchAll($sql)) {
            foreach($gdata as $_row) $mem_type[] = $_row['str_group'];
        }
   
        setCookie('AUTH',true,0,'/','.'.HOST);
        setCookie('USERID',$data['str_id'],0,'/','.'.HOST);
  
        $_SESSION['AUTH'] = true;
        $_SESSION['REMOTE_ADDR'] = getenv('REMOTE_ADDR');
        $_SESSION['MEM_TYPE'] = $mem_type;
        $_SESSION['_FCODE'] = $data['num_fcode'];
		$_SESSION['USERID'] = $data['str_id'];
        $_SESSION['NAME'] = $data['str_name'];
        $_SESSION['ICON'] = $data['str_icon'];
		$_SESSION['PASSWORD'] = $data['str_passwd'];
		$_SESSION['E_MAIL'] = $data['str_email'];
        $_SESSION['CHR_MTYPE'] = $data['chr_mtype'];

		 $_SESSION['STR_GROUP'] = $data['str_group'];
		 $_SESSION['STR_STATE'] = $data['str_state'];
		 $_SESSION['NUM_GRADE'] = $data['num_grade'];
		 $_SESSION['NUM_HID'] = $data['num_hid'];

        $USER_TYPE = $_SESSION['CHR_MTYPE'];
        //echo "USER_TYPE:$USER_TYPE";exit;
        if($data['num_fcode']) { $_SESSION['FCODE'] = $data['num_fcode']; }
		else{
		
		$sql = "select count(*) from tab_class_formation where num_oid = '$_OID' ";
		$class_max = $DB -> sqlFetchOne($sql);
		

		

		}

		echo "<script type='text/javascript'>document.cookie = 'NAME=".$data['str_name']."';</script>";
        
		if($_SESSION['redir']) {
          $redir = $_SESSION['redir'];
          unset($_SESSION['redir']);
        } else {
          $redir = '/';
        }        
      }
      else {
        $mem_type = array('n');
        echo "
        <script>
        alert('회원승인 확인중입니다');
        history.go(-1);
        </script>
        ";
      }		


		if($class_max > 0 && $data['chr_mtype'] != "t" ) {

		WebApp::redirect("/member.modify","회원의 학급정보가 없습니다. \n\n회원정보수정에서 학급을 선택해주세요.");
		exit;
		}

			WebApp::redirect($redir);
		} else {
			WebApp::moveBack('아이디 또는 비밀번호가 일치하지 않습니다.');
		}
		break;
}

?>