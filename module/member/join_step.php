<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2009-07-29
* 작성자: 김종태
* 설   명: 회원 중복확인
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');


switch ($REQUEST_METHOD) {
	case "GET":
	$DOC_TITLE = "str:회원가입";
	$tpl->setLayout('@sub');
	$tpl->define("CONTENT", Display::getTemplate("member/join_step.htm"));
	
	 break;
	case "POST":
	if($str_m <10) $str_m= "0".$str_m;
	if($str_d <10) $str_d= "0".$str_d;
	 $num_birthday = $str_y.$str_m.$str_d;
	
	

	 $sql = "select count(*) from TAB_MEMBER where num_oid = $_OID and str_name = '$str_name' and num_birthday = $num_birthday and chr_birthday = '$chr_birthday' and chr_mtype = '$chr_type' and str_sex = $str_sex ";
	 $row = $DB -> sqlFetchOne($sql);

	if($row  >0) {
	
	echo '<script>alert("이미 가입되어있습니다.");history.go(-1)</script>';
	
	
	
	}else{

	echo "<meta http-equiv='Refresh' Content=\"0; URL='/member.join?num_birthday=$num_birthday&chr_mtype=$chr_type&str_name=".urlencode($str_name)."&chr_birthday=$chr_birthday&str_sex=$str_sex'\">";
	}
	 
	 
	 break;
	}

?>