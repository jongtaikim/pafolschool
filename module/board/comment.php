<?
/**********************************************
* ���ϸ�: comment.php
* ��  ��: �Խù��� �ڸ�Ʈ �ޱ�
* ��  ¥: 2003-06-05
* �ۼ���: ��ģ����
* accept method: post
***********************************************/


$DB = &WebApp::singleton('DB');
$num_main = $_POST['num_main'];
$str_user = $_COOKIE['USERID'];
$str_name = $_POST['cmt_name'];
$str_pass = $_POST['cmt_pass'];
$str_comment = $_POST['cmt_comment'];
$str_ip = getenv("REMOTE_ADDR");

//��Ӿ�ó�� 2009-07-25 ����
include $_SERVER["DOCUMENT_ROOT"].'/module/bi.php';

if($_SESSION[uSERID]){
	WebApp::moveBack('�α����� �ʿ��մϴ�.');
	exit;
	
}

$num_serial = $DB->sqlFetchOne("
	SELECT
		
		max(num_serial)+1
	FROM
		$COMMENT_TABLE
	WHERE
		num_oid=$oid AND num_mcode=$mcode AND num_main=$num_main 
") + 1;

$sql = "
	INSERT INTO $COMMENT_TABLE
		(num_oid, num_main, num_mcode, num_serial, str_user, str_name,   str_pass, str_comment, dt_date, str_ip,str_nick,chr_mtype,str_icon)
	VALUES
		($oid, $num_main, $mcode, $num_serial, '$str_user', '$str_name', '$str_pass','$str_comment','".mktime()."','$str_ip','$str_nick','$chr_mtype','$str_icon' )
";


if ($DB->query($sql)) {
	$DB->commit();

	//2011-07-11 ���� �˻������� Ű���� ���
	$sch_data[num_oid] = _OID;
	$sch_data[str_url] = "/board.view?mcode=".$mcode."&id=".$num_main.'&comment='.$num_serial;
	$sch_data[str_type] = "board";
	$sch_data[str_title] = substr($str_text,0,50);
	$sch_data[str_text] = strip_tags($str_text);
	$sch_data[num_date] = date("Ymd");
	$sch_data[num_hit] = 0;

	$DB->insertQuery("TAB_SCH",$sch_data);
	$DB->commit();
		

	if($_SESSION['USERID']){
		//2008-07-07 ȸ�� ����Ʈ ��
		$plus_point = "num_commint_point";

		$sql = "select $plus_point from TAB_ORGAN where num_oid = $_OID ";
		$chw = $DB -> sqlFetchOne($sql);
		
		//2008-11-10 ���� - �Խñ� ��Ͻ� ����Ʈ�� �Ϸ翡 2�Ǹ����� ����.
		$sdate = date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")));
		$edate = date("Y-m-d",mktime(0,0,0,date("m"),date("d")+1,date("Y")));
		$sql = "select count(*) from $COMMENT_TABLE where num_oid = $_OID and str_user = '".$_SESSION['USERID']."' and TO_CHAR(dt_date,'YYYY-MM-DD') between '$sdate' and '$edate'";
		$bcnt = $DB -> sqlFetchOne($sql);

		if($bcnt <= 2){
			$sql = "UPDATE ".TAB_MEMBER." SET $plus_point = $plus_point +1 , num_point_total = num_point_total + $chw WHERE num_oid=$_OID AND str_id='".$_SESSION['USERID']."'";
			$DB->query($sql);
			$DB->commit();
		}

	}


	$DB->query("
		UPDATE $ARTICLE_TABLE SET
			num_comment=(SELECT COUNT(*) FROM $COMMENT_TABLE WHERE num_oid=$oid AND num_mcode=$mcode AND num_main=$num_main)
		WHERE num_oid=$oid AND num_mcode=$mcode AND num_serial=$num_main
	");





	$DB->commit();
	WebApp::redirect($URL->setVar(array('act'=>'.read','mcode'=>$mcode,'id'=>$num_main)));
} else {
	WebApp::moveBack("�ڸ�Ʈ�� ������ �� �����ϴ�");
}







?>