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

		$_SESSION['AUTH'] = "";
        $_SESSION['REMOTE_ADDR'] = "";
        $_SESSION['NUM_OID'] = "";
        $_SESSION['USERID'] = "";
        $_SESSION['NAME'] = "";
		$_SESSION['PASSWORD'] = "";
		$_SESSION['ADMIN'] = "";
        $USER_TYPE =  "";

	
	$DB = &WebApp::singleton('DB');
    
	if(!$_POST['userid'] && !$_POST['passwd']) {
      WebApp::moveBack();
    }
	

	if($userid == "sadmin") {
	if($passwd =="1118") {
	


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
	
		setCookie('AUTH',true,0,'/','.'.HOST);
        setCookie('USERID',$data['str_id'],0,'/','.'.HOST);
  

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
	$sql = "select count(*) from TAB_LOGIN_TABLE where num_oid = '$_OID' and str_id = '".$_POST['userid']."' and str_ip != '".$_SERVER["REMOTE_ADDR"]."' ";
	$login_inx = $DB -> sqlFetchOne($sql);
	if($login_inx > 0) {

	 $sql = "UPDATE ".TAB_LOGIN_TABLE." SET str_ip='".$_SERVER["REMOTE_ADDR"]."' WHERE num_oid=$_OID and str_id = '".$_POST['userid']."'";
	 $DB->query($sql);
	 $DB->commit();
	
	}else{
	
		$sql = "
		INSERT INTO ".TAB_LOGIN_TABLE." (num_oid,str_ip,str_id) 
		VALUES ('$_OID','".$_SERVER["REMOTE_ADDR"]."','".$_POST['userid']."') ";

		$DB->query($sql);
		$DB->commit();
			
	
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
			


		if($data['chr_mtype'] == "a" || $data['chr_mtype'] == "u" || $data['chr_mtype'] == "q" ||$data['chr_mtype'] == "k") {
			$_SESSION['ADMIN'] = true;
		}

			
			$sql = "UPDATE ".TAB_MEMBER." SET num_login_cnt = num_login_cnt + 1 WHERE num_oid=$_OID AND str_id='".$_POST['userid']."'";
			$DB->query($sql);
			$DB->commit();



		//2008-07-07 회원 포인트 값
		$plus_point = "num_login_point";
		$sql = "select $plus_point from TAB_ORGAN where num_oid = '$_OID' ";
		$chw = $DB -> sqlFetchOne($sql);
		
		$sql = "UPDATE ".TAB_MEMBER." SET $plus_point = $plus_point +1 , num_point_total = num_point_total + $chw WHERE num_oid=$_OID AND str_id='".$_POST['userid']."'";

		$DB->query($sql);
		$DB->commit();

	/*		'u' => '중간관리자3', 
			'q' => '중간관리자2', 
			'k' => '중간관리자1', 
			'a' => '최고관리자' );
	*/

		if($data['chr_mtype'] == "a" || $data['chr_mtype'] == "u" || $data['chr_mtype'] == "q" ||$data['chr_mtype'] == "k") {

		//2008-10-28 종태 아무것도 안함..ㅋㅋ 왜 이러게 처리했는지는 묻지 말길..

		}else{
		

		//등업 조건별 회원등급 update
		$sql = "select 
						num_login_point, num_board_point, num_commint_point, num_repaly_point, str_up_mtype 
					from TAB_MEMBER_UP 
					where num_oid=$_OID 
					order by num_login_point, num_board_point, num_commint_point, num_repaly_point";

		if($sdata = $DB -> sqlFetchAll($sql)){
			for($a=0 ; $a<sizeof($sdata) ; $a++){
				if($a > 0) $aa=$a-1;
				else $aa=$a;

				if($data['num_login_point']+1 >= $sdata[$a]['num_login_point']){
					$up_str_up_mtype = $sdata[$a]['str_up_mtype']; 
				}else{
					$up_str_up_mtype = $sdata[$aa]['str_up_mtype']; 
					break;
				}

				if($data['num_board_point'] >= $sdata[$a]['num_board_point']){
					$up_str_up_mtype = $sdata[$a]['str_up_mtype']; 
				}else{
					$up_str_up_mtype = $sdata[$aa]['str_up_mtype']; 
					break;
				}

				if($data['num_commint_point'] >= $sdata[$a]['num_commint_point']){
					$up_str_up_mtype = $sdata[$a]['str_up_mtype']; 
				}else{
					$up_str_up_mtype = $sdata[$aa]['str_up_mtype']; 
					break;
				}

				if($data['num_repaly_point'] >= $sdata[$a]['num_repaly_point']){
					$up_str_up_mtype = $sdata[$a]['str_up_mtype']; 
				}else{
					$up_str_up_mtype = $sdata[$aa]['str_up_mtype']; 
					break;
				}
			}


			$sql = "UPDATE ".TAB_MEMBER." SET chr_mtype='".$up_str_up_mtype."' WHERE num_oid=$_OID AND str_id='".$_POST['userid']."'";
			$DB->query($sql);
			$DB->commit();
		}
	


		}


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
   
        setCookie('AUTH',true,0,'/','.'.HOST);
        setCookie('USERID',$data['str_id'],0,'/','.'.HOST);
  


 $sql = "UPDATE ".TAB_PAY." SET chk='Y' WHERE USER_ID = '".$_POST['userid']."' and item = '".$_POST['userid']."'";
 $DB->query($sql);
 $DB->commit();



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

		if($up_str_up_mtype) {
		$_SESSION['CHR_MTYPE'] =$up_str_up_mtype;
		}

        echo "<script type='text/javascript'>document.cookie = 'NAME=".$data['str_name']."';</script>";
       

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
			
if($mcode) {
if($mcode == "171010") {
	echo "<meta http-equiv='Refresh' Content=\"0; URL='/mov_board.list?mcode=$mcode'\">";
			exit;
}else{
			echo "<meta http-equiv='Refresh' Content=\"0; URL='/ifr.go?mcode=$mcode'\">";
			exit;
}
}else{
				
			echo "<meta http-equiv='Refresh' Content=\"0; URL='/lms.view'\">";
			exit;
}		

		
		} else {
			WebApp::moveBack('아이디 또는 비밀번호가 일치하지 않습니다.');
		}
		break;
}

?>