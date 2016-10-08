<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-09-23
* 작성자: 김종태
* 설  명: 회원 탈퇴 사유를 적엏라
*****************************************************************
* 
*/

switch ($REQUEST_METHOD) {
	case "GET":
	
	$DOC_TITLE="str:회원탈퇴하기";

	$tpl->setLayout();
	$tpl->define("CONTENT", Display::getTemplate("member/del.htm"));
	
	 break;
	case "POST":
	$DB = &WebApp::singleton('DB');

	if( $_SESSION[USERID] == "admin") {
	WebApp::moveBack('장난치지 마세요.');
	exit;
	}

	$sql = "select max(num_serial)+1 from TAB_MEMBER_DEL where num_oid = '$_OID' ";
	$max = $DB -> sqlFetchOne($sql);
	if(!$max) $max  = 1;
	
	

	$sql = "INSERT INTO ".TAB_MEMBER_DEL." 
	(num_oid, num_serial,str_id,str_title,str_text
		) VALUES 
	('$_OID', '$max','".$_SESSION[USERID]."','$str_title','$str_text') ";
	
	$DB->query($sql);
	$DB->commit();
				
	 $sql = "delete from  TAB_MEMBER where num_oid = '".$_OID."' and str_id = '".$_SESSION[USERID]."'";
	 $DB->query($sql);
	 $DB->commit();
	
	echo '<script>alert("정상적으로 탈퇴 되었습니다.\n감사합니다.");</script>';
	echo "<meta http-equiv='Refresh' Content=\"0; URL='member.logout'\">";
	
	
	break;
	}

?>