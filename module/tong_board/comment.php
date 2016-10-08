<?
/**********************************************
* 파일명: comment.php
* 설  명: 게시물에 코멘트 달기
* 날  짜: 2003-06-05
* 작성자: 거친마루
* accept method: post
***********************************************/


$DB = &WebApp::singleton('DB');
$num_main = $_POST['num_main'];
$str_user = $_COOKIE['USERID'];
$str_name = $_POST['cmt_name'];
$str_pass = $_POST['cmt_pass'];
$str_comment = $_POST['cmt_comment'];
$str_ip = getenv("REMOTE_ADDR");






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
		(num_oid, num_main, num_mcode, num_serial, str_user, str_name,   str_pass, str_comment, dt_date, str_ip,str_nick,chr_mtype,str_icon)
	VALUES
		($oid, $num_main, $mcode, $num_serial, '$str_user', '$str_name', '$str_pass','$str_comment',sysdate,'$str_ip','$str_nick','$chr_mtype','$str_icon' )
";


if ($DB->query($sql)) {
	$DB->commit();

	if($_SESSION['USERID']){
		//2008-07-07 회원 포인트 값
		$plus_point = "num_commint_point";

		$sql = "select $plus_point from TAB_ORGAN where num_oid = $_OID ";
		$chw = $DB -> sqlFetchOne($sql);
		
		//2008-11-10 현민 - 게시글 등록시 포인트는 하루에 2건만으로 제한.
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
	WebApp::moveBack("코멘트를 저장할 수 없습니다");
}







?>