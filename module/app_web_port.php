<?php
/*
작성자 : 
작성일 : 
용  도 : 방과후 수업 신청 로직

	echo "<script>alert('개발중!!');window.close();</script>";
	exit;
}
*/
/* 강화여고 날짜 및 시간에 따른 학년별 수강신청 제한 */

$ARTICLE_TABLE = "TAB_MEMBER_MERGE";
$RANK_TABLE = "TAB_MEMBER_RANK";

$DB = WebApp::singleton("DB");

$After_DB = $DB;

$sql = "select count(*) from LEC_ORG_INFO where num_oid = $_OID ";
$row = $DB -> sqlFetchOne($sql);

if(!$row){
global $organdb;
$sql = "Insert into LEC_ORG_INFO
   (NUM_OID, STR_ADMIN_ID, STR_ADMIN_PW, ADMIN_NAME, ADMIN_TEL, ADMIN_PHONE, ADMIN_EMAIL, SCHOOL_NAME, SCHOOL_DOMAIN)
 Values
   ("._OID.", 'admin', '0000', '방과후관리자', '".$organdb[str_phone]."', '', '', '".$organdb[str_organ]."', '".$organdb[str_domain]."')";
	 if($DB->query($sql)){
		 $DB->commit();
	 }
}


$sql = "SELECT main_flag FROM lec_main_info WHERE num_oid=$oid AND use_yn='Y'";
$main_data = $After_DB->sqlfetchOne($sql);
if(($main_data=="login") && !$_SESSION['ADMIN']) {

	if( !$_SESSION['USERID'] ){

		echo "<script>alert('본 서비스는 회원정보를 필요로 합니다. 로그인 후 사용해 주십시요!!');window.close();</script>";
		exit;
	}

}


$afterschool_type = $_SESSION['MEM_TYPE'] ? implode(",",$_SESSION['MEM_TYPE']):"";

$sql = "SELECT count(*) FROM lec_teacher WHERE num_oid=$oid AND str_id='".$_SESSION['USERID']."'";
$type_data = $After_DB->sqlfetchOne($sql);

//방과후 강사 타입
if($type_data>0) $afterschool_type .= ',z';



if($_SESSION['TMP_TYPE']=='t')$level_auth = (!$_SESSION['ADMIN']) ? 1 : 4 ;
if($_SESSION[USERID]){
echo "
<form name='orderform' method='post' action='http://afterschool.".DOMAIN_."/?act=member.in_page'>
<input type='hidden' name='OID' value='"._OID."'>
<input type='hidden' name='HOST__' value='".HOST."'>
<input type='hidden' name='DOMAIN' value='".DOMAIN_."'>
<input type='hidden' name='web_oid' value='"._OID."'>
<input type='hidden' name='web_admin' value='".$_SESSION['ADMIN']."'>
<input type='hidden' name='web_user_id' value='".$_SESSION['USERID']."'>
<input type='hidden' name='web_ip' value='".$_SESSION['REMOTE_ADDR']."'>
<input type='hidden' name='web_mem_type' value='".strtolower($afterschool_type)."'>
<input type='hidden' name='web_user_name' value='".$_SESSION['NAME']."'>
</form>
<SCRIPT LANGUAGE='JavaScript'>
<!--
orderform.submit();
//-->
</SCRIPT>
";
}else{
WebApp::closeWin(false,'로그인이 필요합니다.');
}
?>