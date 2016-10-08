<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-10-27
* 작성자: 김종태
* 설   명: 전체메일 보내기
*****************************************************************
*
*/
$DB = &WebApp::singleton('DB');


switch ($REQUEST_METHOD) {
case "GET":
	$sql = "select count(*) from TAB_MEMBER where num_oid = $_OID";
	$total = $DB -> sqlFetchOne($sql);

	$tpl->assign(array("total"=>$total));
	$tpl->setLayout('no3');
	$tpl->define("CONTENT", Display::getTemplate("memo/all_send.htm"));

break;
case "POST":

	$content = WebApp::ImgChaneDe($str_text);

	$sql = "select str_id from TAB_MEMBER where num_oid = $_OID";
	$all_member = $DB -> sqlFetchAll($sql);

	$sql = "select max(num_serial)+1 from TAB_MEMO where num_oid = $_OID";
	$max_num_serial = $DB -> sqlFetchOne($sql);

	if(!$max_num_serial) $max_num_serial  = 1;

	//$str_title = "<font color='#e9084d'>[전체 쪽지]</font> ".$str_title;

	for($ii=0; $ii<count($all_member); $ii++) {
		
		$sql = "INSERT INTO ".TAB_MEMO." (
		NUM_OID,
		STR_SEND_ID,
		STR_TO_ID,
		NUM_SERIAL,
		STR_TITLE,
		STR_TEXT,
		STR_SEND_DATE,
		STR_SEND_NAME,
		STR_SEND_NICK

		) VALUES (

		$_OID,
		'".$_SESSION[USERID]."',
		'".$all_member[$ii]["str_id"]."',
		$max_num_serial,
		'$str_title',
		'$str_text',
		'".mktime()."',
		'".$_SESSION['NAME']."',
		'".$_SESSION['NICKNAME']."'
		) ";
	
		if($DB->query($sql)){
			$DB->commit();

		}
		$max_num_serial++;
		
	}
		echo '<script>alert("'.count($all_member).' 회원에게 쪽지 발송 완료");</script>';
		WebApp::moveBack();
	break;
}

?>
