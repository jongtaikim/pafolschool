<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2009-01-02
* 작성자: 이현민
* 설   명: 카페탈퇴하기
*****************************************************************
* 
*/
if(!$_SESSION[USERID]) {
	$_SESSION['reurl'] = $act."?pcode=$pcode";
	echo "<meta http-equiv='Refresh' Content=\"0; URL='/member.login'\">";
	exit;
}

if($cafe_admin_data[cm_id] != $_SESSION[USERID]){
$sql = "delete from TAB_PARTY_MEMBER where num_oid=$_OID and num_pcode=$pcode and str_id='".$_SESSION[USERID]."'";
$DB->query($sql);
if($DB->commit()){
	$sql = "update TAB_PARTY set num_user=num_user-1 where  num_oid=$_OID and num_pcode=$pcode";
	$DB->query($sql);
	$DB->commit();

	WebApp::redirect("/party.main?pcode=$pcode","탈퇴되었습니다.");
}else{
WebApp::moveBack('장난치냐?');


}


}else{
	WebApp::moveBack('Error!!!');
}

?>
