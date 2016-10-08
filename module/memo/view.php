<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-11-24
* 설   명: 쪽지보기
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');
function loginChk(){
if(!$_SESSION[USERID]) {
	echo '<script>alert("로그인이 필요합니다."); self.close();</script>';
	exit;
}
}


loginChk();
$tpl->define("MEMO_TOP", Display::getTemplate("memo/top.htm"));
	

switch ($REQUEST_METHOD) {
	case "GET":
	
	

	$sql = "select * from TAB_MEMO where num_oid = $_OID and num_serial = '$id' and str_to_id = '".$_SESSION[USERID]."'";
	if($data = $DB -> sqlFetch($sql)){
	$tpl->assign($data);
	
	 $sql = "UPDATE ".TAB_MEMO." SET str_reading_date=".mktime()." WHERE num_oid = $_OID and num_serial = '$id' and str_to_id = '".$_SESSION[USERID]."'";
	 $DB->query($sql);
	 $DB->commit();
	
	}
	$tpl->setLayout('admin');
	$tpl->define("CONTENT", Display::getTemplate("memo/view.htm"));
	
	 break;
	case "POST":

		switch ($mode) {
			case "delete":

				$sql = "UPDATE TAB_MEMO SET str_to_del='Y' WHERE num_oid=$_OID and str_to_id='".$_SESSION[USERID]."' and num_serial=$id";
				$DB->query($sql);
				$DB->commit();

				WebApp::moveBack('삭제했습니다.');

			break;
			case "save":

				$sql = "UPDATE TAB_MEMO SET str_save='Y' WHERE num_oid=$_OID and str_to_id='".$_SESSION[USERID]."' and num_serial=$id";
				$DB->query($sql);
				$DB->commit();

				WebApp::moveBack('쪽지를 보관함으로 옮겼습니다.');

			break;

		}

	 break;
	}

?>