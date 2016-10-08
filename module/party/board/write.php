<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/party/board/write.php
* 작성일: 2006-05-16
* 작성자: 이범민
* 설  명: 게시판 글 새로 작성
*****************************************************************
* 
*/
include _DOC_ROOT.'/module/file.php';

if(!$env['writable']) WebApp::raiseError('권한이 없습니다.');
$FH = &WebApp::singleton('FileHost','party',$pcode.'.'.$mcode);
$FH->set_oid($_OID);

if(!$_SESSION[USERID]) {
	$_SESSION['reurl'] = $act."?pcode=$pcode";
	echo "<meta http-equiv='Refresh' Content=\"0; URL='/member.login'\">";
	exit;
}

switch ($REQUEST_METHOD) {
case "GET":


	
	$tpl->define("CONTENT", "html/party/board/skin/".$board_skin."/write.htm");
	$tpl->assign(array('str_title'=>""));//타이틀과 겹치는 경우가 있음
	
	

	$serial = $DB->sqlFetchOne("
					SELECT
						/*+ INDEX_DESC (TAB_PARTY_BOARD PK_TAB_PARTY_BOARD_PK) */
						max(num_serial)+1
					FROM
						$ARTICLE_TABLE
					WHERE
						num_oid=$_OID AND num_pcode=$pcode AND num_mcode=$mcode
				");

	if(!$serial) $serial = 1;
	$FH->delete_as_main($serial);

	list($num_disk, $num_upload_size, $db_num_size, $use_size, $maxfilesize) = WebApp::OIDUploadFileSize();
	$tpl->assign(array(
		'num_disk'=>$num_disk,
		'num_upload_size'=>$num_upload_size,
		'db_num_size'=>$db_num_size,
		'use_size'=>$use_size,
		'maxfilesize'=>$maxfilesize,
		'mcode'=>$mcode
	));

break;
case "POST":

	
	
	$DB = &WebApp::singleton('DB');
	$serial = $DB->sqlFetchOne("
					SELECT
						/*+ INDEX_DESC (TAB_PARTY_BOARD PK_TAB_PARTY_BOARD_PK) */
						max(num_serial)+1
					FROM
						$ARTICLE_TABLE
					WHERE
						num_oid=$_OID AND num_pcode=$pcode AND num_mcode=$mcode
					");
	if (!$serial) $serial = 1;

	$group = $DB->sqlFetchOne("
					SELECT
						/*+ INDEX_DESC (TAB_PARTY_BOARD PK_TAB_PARTY_BOARD_PK) */
						max(num_group) + 1
					FROM
						$ARTICLE_TABLE
					WHERE
						num_oid=$_OID AND num_pcode=$pcode AND num_mcode=$mcode
					");
	if (!$group) $group = 1;
	$depth = 0;
	$step = 0;

	$num_notice = $_POST['num_notice'] ? $_POST['num_notice'] : 0;
	$user = $_SESSION['USERID'];
	$name = $_POST['str_name'];
	$title = $_POST['str_title'];
	$pass = $_POST['str_pass'];
	$email = $_POST['str_email'];
	$upfiles = $_POST['upfiles'];
	$str_text = $_POST['content'];
	$use_html = $_POST['use_html'];
	if (!$use_html) $use_html = 'Y';
	$ip = getenv('REMOTE_ADDR');
	if($num_hit2) {
		$num_hit = $num_hit2;
	}
	$dt_date = $_POST['dt_date'] ? "TO_DATE('".$_POST['dt_date']."','YYYY-MM-DD')" : 'SYSDATE';
	
	if(!$num_hit) $num_hit = 0;

	if(!$str_text) $str_text = "<p></p>";

	//비속어처리 2009-07-25 종태
	include $_SERVER["DOCUMENT_ROOT"].'/module/bi.php';


	$title = str_replace("'","''",$title);
	//$str_text = str_replace("'","''",$str_text);
	
	$str_text = WebApp::ImgChaneDe($str_text, $serial);
	//$str_thumb = ImgGetThumb($str_text,$serial);	//게시판썸네일추가

	$sql = 
	"INSERT INTO $ARTICLE_TABLE
		(num_oid, num_pcode, num_mcode, num_serial, num_notice, num_group, num_step, num_depth, str_user, str_name, str_pass,
		str_email, str_title, str_text,chr_html, dt_date, str_ip, num_input_pass, str_thumb)
	VALUES
		($_OID,$pcode,$mcode,$serial,$num_notice,$group,$step,$depth,'$user','$name','$pass', 
		'$email','$title',:str_text,'$use_html',$dt_date,'$ip','$num_input_pass', '$str_thumb')
	";



	if ($DB->query_clob($sql,$str_text)) {
		$DB->commit();

	//2009-07-01 종태 신규 업로드 프로세서
		$FH = &WebApp::singleton('FileHost');
		$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));

		$FTP->mkdir($FH->file_dir);
		$FTP->chmod($FH->file_dir,777);
		$FTP->mkdir($FH->file_dir."/".date("Ym")."/");
		$FTP->chmod($FH->file_dir."/".date("Ym")."/",777);


		
		for($ii=1; $ii<11; $ii++) {
			uploadFile($ii);
		}

		
		if($_SESSION['get_thumb_filename']){
			$sql = "
                UPDATE
                    $ARTICLE_TABLE
                SET
                   str_thumb='".$_SESSION['get_thumb_filename']."'
                WHERE
                    num_oid = "._OID." and num_pcode = $pcode and num_mcode=$mcode AND num_serial=$serial";


		  if ($DB->query($sql)) $DB->commit();
			
		}
			$_SESSION['get_thumb_filename'] = "";
			unset($_SESSION['get_thumb_filename']);



		

		$sql = "update TAB_PARTY set num_board=num_board+1 where  num_oid=$_OID and num_pcode=$pcode";
		$DB->query($sql);
		$DB->commit();

		$sql = "update TAB_PARTY_MEMBER set num_board=num_board+1 where  num_oid=$_OID and num_pcode=$pcode and str_id='$user'";
		$DB->query($sql);
		$DB->commit();

		WebApp::redirect("party.board.list?pcode=$pcode&mcode=$mcode");

	} else {
		$FH->rm_tmp_files($_POST['timestamp']);
		$FH->close();

		WebApp::moveBack('글을 작성할 수 없습니다'.$DB->error['message']);
	}
break;
}

function content_split($str) {
	$ret = array();
	while ($str) {
		$ret[] = substr($str,0,3999);
		$str = substr($str,3999);
	}
	return $ret;
}


?>
