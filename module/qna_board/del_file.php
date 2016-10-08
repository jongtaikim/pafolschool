<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/board/del_file.php
* 작성일: 2004-02-12
* 작성자: 거친마루
* 설  명: 업로드한 파일 삭제하기
*****************************************************************
* 
*/

// TODO: 파일 삭제하기 전에 게시물 소유권 확인후 인증
include_once $APPPATH."/_file_ftp_conn.php";

$id = $_REQUEST['id'];
$DB = &WebApp::singleton('DB');

$data = $DB->sqlFetch("SELECT * FROM $FILE_TABLE WHERE num_oid=$_OID AND num_mcode=$mcode AND num_main=$main AND num_serial=$id");
$filename = $data['str_upfile'];
$filepath = $data['str_refile'];
$filesize = $data['num_size'];

if ($DB->query("DELETE FROM $FILE_TABLE WHERE num_oid=$_OID AND num_mcode=$mcode AND num_main=$main AND num_serial=$id")) {
	$DB->commit();
	file_ftp_conn();
	$source_path = $FILE_FTP_ROOT."/hosts/$_OID/board/".$data['str_refile'];
	$FILE_FTP->delete($source_path);
	$FILE_FTP->close();

	$sql = "UPDATE $ARTICLE_TABLE SET NUM_FILE=NUM_FILE-1 WHERE NUM_OID=$_OID AND NUM_MCODE=$mcode AND NUM_SERIAL=$main";
	if($DB->query($sql)) $DB->commit();
	echo "<script>parent.FA.removeFile($id,$filesize);parent.document.forms['writeform'].elements['origin_num_file'].value -= 1;</script>";
	exit;
} else {
	WebApp::alert('파일을 삭제하지 못했습니다');
}

?>
