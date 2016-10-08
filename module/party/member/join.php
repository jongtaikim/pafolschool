<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2009-01-02
* 작성자: 이현민
* 설   명: 카페가입하기
*****************************************************************
* 
*/
if(!$_SESSION[USERID]) {
	$_SESSION['reurl'] = $act."?pcode=$pcode";
	echo "<meta http-equiv='Refresh' Content=\"0; URL='/member.login'\">";
	exit;
}

switch ($REQUEST_METHOD) {
	case "GET":

		$tpl->assign(array('cafe_mtype_nm'=>$_cafe_mtypes[$cafe_data['str_mtype']]));
		$tpl->define("CONTENT", Display::getTemplate("party/member/join.htm"));
	
	break;
	case "POST":
		$sql = "select count(*) from TAB_PARTY_MEMBER where num_oid=$_OID and num_pcode=$pcode and str_id='".$_SESSION['USERID']."'";
		$count = $DB -> sqlFetchOne($sql);
		if($count){
			WebApp::moveBack('이미 가입되어 있습니다.');
		}

		$str_ip = getenv("REMOTE_ADDR");

		$sql = "insert into TAB_PARTY_MEMBER(num_oid, num_pcode, str_id, str_mtype, str_text1, str_text2, str_text3, str_text4, str_text5, str_ip, str_date) 
					values('$_OID', '$pcode', '".$_SESSION['USERID']."', '".$cafe_data['str_mtype']."', '$str_text1', '$str_text2', '$str_text3', '$str_text4', '$str_text5', '$str_ip', '".mktime()."')";
		$DB->query($sql);
		if($DB->commit()){
			$sql = "update TAB_PARTY set num_user=num_user+1 where  num_oid=$_OID and num_pcode=$pcode";
			$DB->query($sql);
			$DB->commit();

			WebApp::redirect("/party.main?pcode=$pcode","가입되었습니다.");
		}else{
			WebApp::moveBack('Error!!!');
		}

	break;
}
?>
