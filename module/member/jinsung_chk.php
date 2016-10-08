<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-01-30
* 작성자: 김종태
* 설  명: 사이트 신청
*****************************************************************
* 
*/
$DB = &WebApp::singleton("DB");
switch ($REQUEST_METHOD) {
	case "GET":
	
	$tpl->setLayout('admin');
	$tpl->define("CONTENT", "/html/member/jinsung_chk.htm");
	
	 break;
	case "POST":



$sql = "select STR_CONFIRM_CODE from TAB_MEM_CONFIRM where num_oid = '$_OID' and STR_CONFIRM2 = '$str_confirm1'
 AND STR_NAME = '$str_name' ";

$id_rr = $DB -> sqlFetchOne($sql);
if(!$id_rr) {
WebApp::moveBack('일치하는 정보가 없습니다.');

}else{

$sql = "select count(str_id) from TAB_MEMBER where num_oid = '$_OID' and str_id = '$id_rr' ";
$chk1 = $DB -> sqlFetchOne($sql);

if($chk1 > 0) {
WebApp::moveBack('이미 회원가입되어있는 인증코드입니다. 관리자에게 확인해부세요.');	
exit;
}



$haknun = substr($id_rr , 5 ,1);
$ban = substr($id_rr , 6 ,2) -1;

echo "<script>
parent.closew2();
parent.selint('$id_rr','$haknun','$ban','$str_name');
</script>";
}

	 break;
	}

?>

 