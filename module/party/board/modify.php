<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/party/board/modify.php
* 작성일: 2006-05-16
* 작성자: 이범민
* 설  명: 게시판 글 수정
*****************************************************************
* 
*/
include _DOC_ROOT.'/module/file.php';
$id = $_REQUEST['id'];

if(!$env['writable']) WebApp::raiseError('권한이 없습니다.');
$DB = &WebApp::singleton('DB');
$FH = &WebApp::singleton('FileHost','party',$pcode.'.'.$mcode);
$FH->set_oid($_OID);

switch(REQUEST_METHOD) {
case "GET":
	$timestamp = date('U');
	if($id === false) WebApp::moveBack('해당 글이 존재하지 않습니다');
	$sql = "
	SELECT
		num_mcode AS mcode,num_serial AS serial,num_notice,str_user,str_name AS name,str_pass,str_email AS email,str_title,str_text, chr_html AS use_html, TO_CHAR(dt_date,'YYYY-MM-DD') AS reg_date,
		num_hit AS hit, num_file, str_ip AS remote_addr,  str_pass as pass, num_comment, str_thumb, num_input_pass
	FROM
		$ARTICLE_TABLE
	WHERE
		num_oid=$_OID AND num_pcode=$pcode AND num_mcode=$mcode AND num_serial=$id
	";
	$data = $DB->sqlFetch($sql);
	_format_data(&$data);

	$data['content'] = $FH->set_content($data['content']);

	$tpl->define("CONTENT","html/party/board/skin/".$board_skin."/write.htm");

	if($data['FILE_LIST'] = $FH->get_files_info($id)) $data['total_size'] = array_pop($data['FILE_LIST']);

	$tpl->assign($data);
	$tpl->assign(array(
	'id'=>$id,
	));

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
	if($id === false) WebApp::moveBack('해당 글이 존재하지 않습니다');
	
	$serial = $id;

	$originPw = $DB->sqlFetchOne("SELECT str_pass FROM $ARTICLE_TABLE WHERE num_oid=$_OID AND num_pcode=$pcode AND num_mcode=$mcode AND num_serial=$id");
	if($_POST['str_pass'] != $originPw) WebApp::moveBack('패스워드가 일치하지 않습니다');

	$num_notice = $_POST['num_notice'] ? $_POST['num_notice'] : 0;
	$name = $_POST['str_name'];
	$title = $_POST['str_title'];
	$pass = $_POST['str_pass'];
	$email = $_POST['str_email'];
	$use_html = $_POST['use_html'];
	$origin_num_file = $_POST['origin_num_file'];
	if (!$use_html) $use_html = 'Y';
	$num_hit = $_POST['num_hit'] ? $_POST['num_hit'] : false;
	$dt_date = $_POST['dt_date'] ? "TO_DATE('".$_POST['dt_date']."','YYYY-MM-DD ')" : false;

	if(!$str_text) $str_text = "<p></p>";

	//비속어처리 2009-07-25 종태
	include $_SERVER["DOCUMENT_ROOT"].'/module/bi.php';

	
	$str_text = $_POST['content'];
	$title = str_replace("'","''",$title);
	//$str_text = str_replace("'","''",$str_text);
	$str_text = WebApp::ImgChaneDe($str_text, $id);
	

	

	$sql = "
	UPDATE
		$ARTICLE_TABLE
	SET
		num_notice=$num_notice, str_title='$title',str_text=:str_text,
		str_name='$name',str_email='$email', chr_html='$use_html', num_input_pass='$num_input_pass', str_thumb='$str_thumb'".
		($num_hit ? ', num_hit='.$num_hit.' ' : '').
		($dt_date ? ', dt_date='.$dt_date.' ' : '').
	"WHERE
		num_oid=$_OID AND num_pcode=$pcode AND num_mcode=$mcode AND num_serial=$id
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
			




		
		WebApp::redirect("party.board.list?pcode=$pcode&mcode=$mcode");
	} else {
		$FH->rm_tmp_files($_POST['timestamp']);
		$FH->close();
		WebApp::moveBack('글을 수정할 수 없습니다');
	}
break;
}

function _format_data(&$arr) {
	global $env;
	if ($env['admin'] == true) {
		$arr['pass'] = $arr['str_pass'];
	} else 	$arr['str_pass'] = "";
	$arr['name'] = &$arr['name'];
	$arr['title'] = strip_tags(&$arr['title']);
	$arr['content'] = $arr['str_text']->load();
}

function content_split($str) {
	$ret = array();
	while ($str) {
		$ret[] = substr($str,0,4000);
		$str = substr($str,4000);
	}
	return $ret;
}
?>
