<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/party/board/comment.php
* 작성일: 2006-05-16
* 작성자: 이범민
* 설  명: 
*****************************************************************
* 
*/

$PERMCAFE->apply('party',$pcode.'.'.$mcode,'w',$cafe_mtype);
$DB = &WebApp::singleton('DB');
$num_main = $_POST['num_main'];
$str_user = $_SESSION['USERID'];
$str_name = $_POST['cmt_name'];
$str_pass = $_POST['cmt_pass'];
$str_comment = $_POST['cmt_comment'];
$str_ip = getenv("REMOTE_ADDR");


		//비속어처리 2009-07-25 종태
		include $_SERVER["DOCUMENT_ROOT"].'/module/bi.php';



$num_serial = $DB->sqlFetchOne("
	SELECT
		/*+ INDEX_DESC($COMMENT_TABLE $COMMENT_PRIMARY_INDEX) */
		max(num_serial)+1
	FROM
		$COMMENT_TABLE
	WHERE
		num_oid=$_OID AND num_pcode=$pcode AND num_mcode=$mcode AND num_main=$num_main AND rownum=1
");

if(!$num_serial) $num_serial = 1;
$sql = "
	INSERT INTO $COMMENT_TABLE
		(num_oid, num_pcode, num_mcode, num_main, num_serial, str_user, str_name, str_pass, str_comment, dt_date, str_ip)
	VALUES
		($_OID, $pcode, $mcode, $num_main, $num_serial, '$str_user', '$str_name', '$str_pass','$str_comment',sysdate,'$str_ip')
";



if ($DB->query($sql)) {
	$DB->commit();
	$DB->query("
		UPDATE $ARTICLE_TABLE SET
			num_comment=(SELECT COUNT(*) FROM $COMMENT_TABLE WHERE num_oid=$_OID AND num_pcode=$pcode AND num_mcode=$mcode AND num_main=$num_main)
		WHERE num_oid=$_OID AND num_pcode=$pcode AND num_mcode=$mcode AND num_serial=$num_main
	");
	$DB->commit();
	


	$sql = "update TAB_PARTY_MEMBER set num_comment=num_comment+1 where  num_oid=$_OID and num_pcode=$pcode and str_id='$str_user'";
	$DB->query($sql);
	$DB->commit();

	WebApp::moveBack();
	
} else {
	WebApp::moveBack("코멘트를 저장할 수 없습니다");
}
?>