<?
/**********************************************
* ���ϸ�: comment.php
* ��  ��: �Խù��� �ڸ�Ʈ �ޱ�
* ��  ¥: 2003-06-05
* �ۼ���: ��ģ����
* accept method: post
***********************************************/

$PERM->apply('menu',$mcode,'w');
$DB = &WebApp::singleton('DB');
$num_main = $_POST['num_main'];
$str_user = $_COOKIE['USERID'];
$str_name = $_POST['cmt_name'];
$str_pass = $_POST['cmt_pass'];
$str_comment = $_POST['cmt_comment'];
$str_ip = getenv("REMOTE_ADDR");



if($mcode >= 900000) { // �ý��� �Խ����� ���� OID ������ ������  2007-09-17 ���� 
	

$num_serial = $DB->sqlFetchOne("
	SELECT
		
		max(num_serial)+1
	FROM
		$COMMENT_TABLE
	WHERE
		 num_mcode=$mcode AND num_main=$num_main 
");


if(!$num_serial) $num_serial= 1;
$sql = "
	INSERT INTO $COMMENT_TABLE
		(num_oid, num_main, num_mcode, num_serial, str_user, str_name, str_pass, str_comment, dt_date, str_ip,str_icon)
	VALUES
		($_OID, $num_main, $mcode, $num_serial, '$str_user', '$str_name', '$str_pass','$str_comment',sysdate,'$str_ip','$str_icon')
";


if ($DB->query($sql)) {
	$DB->commit();
	$DB->query("
		UPDATE $ARTICLE_TABLE SET
			num_comment=(SELECT COUNT(*) FROM $COMMENT_TABLE WHERE  num_mcode=$mcode AND num_main=$num_main)
		WHERE  num_mcode=$mcode AND num_serial=$num_main
	");





	$DB->commit();
	WebApp::redirect($URL->setVar(array('act'=>'.read','pcode'=>$pcode,'mcode'=>$mcode,'id'=>$num_main)));
} else {
	WebApp::moveBack("�ڸ�Ʈ�� ������ �� �����ϴ�");
}


}else{



$num_serial = $DB->sqlFetchOne("
	SELECT
		/*+ INDEX_DESC($COMMENT_TABLE $COMMENT_PRIMARY_INDEX) */
		num_serial+1
	FROM
		$COMMENT_TABLE
	WHERE
		num_oid=$oid AND num_mcode=$mcode AND num_main=$num_main AND rownum=1
") + 1;

$sql = "
	INSERT INTO $COMMENT_TABLE
		(num_oid, num_main, num_mcode, num_serial, str_user, str_name, str_pass, str_comment, dt_date, str_ip,str_icon)
	VALUES
		($oid, $num_main, $mcode, $num_serial, '$str_user', '$str_name', '$str_pass','$str_comment',sysdate,'$str_ip','$str_icon')
";
if ($DB->query($sql)) {
	$DB->commit();



		//2008-07-07 ȸ�� ����Ʈ ��
		$plus_point = "num_commint_point";
		$sql = "select $plus_point from TAB_BOARD_CONFIG where num_oid = '$_OID' and num_mcode = '$mcode' ";
		if($chw = $DB -> sqlFetchOne($sql) < 1){
		$sql = "select $plus_point from TAB_ORGAN where num_oid = '$_OID' ";
		$chw = $DB -> sqlFetchOne($sql);
		}

		
		$sql = "UPDATE ".TAB_MEMBER." SET $plus_point = $plus_point + $chw WHERE num_oid=$_OID AND str_id='".$_SESSION['USERID']."'";
		$DB->query($sql);
		$DB->commit();


	$DB->query("
		UPDATE $ARTICLE_TABLE SET
			num_comment=(SELECT COUNT(*) FROM $COMMENT_TABLE WHERE num_oid=$oid AND num_mcode=$mcode AND num_main=$num_main)
		WHERE num_oid=$oid AND num_mcode=$mcode AND num_serial=$num_main
	");





	$DB->commit();
	WebApp::redirect($URL->setVar(array('act'=>'.read','pcode'=>$pcode,'mcode'=>$mcode,'id'=>$num_main)));
} else {
	WebApp::moveBack("�ڸ�Ʈ�� ������ �� �����ϴ�");
}






}
?>