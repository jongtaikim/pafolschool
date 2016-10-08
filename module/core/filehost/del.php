<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/filehost/del.php
* 작성일: 2005-03-14
* 작성자: 이범민
* 설  명: 첨부파일 삭제 URL로 요청
*****************************************************************
* 
*/
$fname = $_REQUEST['fname'];
$sect = $_REQUEST['sect'];
$code = $_REQUEST['code'];
$FH = &WebApp::singleton('FileHost',$sect,$code);
header('Content-Type: text/html; charset=EUC-KR');
if($fname) {
	// FCKeditor의 이미지 삭제 요청
	$fname_prefix = "$FILE_HOST/hosts/$_OID/$sect/";
	$str_refile = str_replace($fname_prefix,'',$fname);
	$FH->delete($str_refile);
	$FH->close();
	$sql = "DELETE FROM ".TAB_FILES."
			WHERE
				NUM_OID=$_OID AND
				STR_SECT='$sect' AND
				STR_CODE='$code' AND
				STR_REFILE='$str_refile'";
	$DB = &WebApp::singleton("DB");
	$DB->query($sql);
	$DB->commit();
} else {
	$main = $_REQUEST['main'];
	$id = $_REQUEST['id'];
	// 글쓰기/수정 폼에서 첨부파일 삭제 요청
	$DB = &WebApp::singleton("DB");
	$sql = "SELECT STR_REFILE,NUM_SIZE FROM ".TAB_FILES."
			WHERE 
				NUM_OID=$_OID AND
				STR_SECT='$sect' AND
				STR_CODE='$code' AND
				NUM_MAIN=$main AND
				NUM_SERIAL=$id";

	if($fdata = $DB->sqlFetch($sql)) {
		$FH->delete($fdata['str_refile']);
		$FH->close();
		$sql = "DELETE FROM ".TAB_FILES."
				WHERE
					NUM_OID=$_OID AND
					STR_SECT='$sect' AND
					STR_CODE='$code' AND
					NUM_MAIN=$main AND
					NUM_SERIAL=$id";
		$DB->query($sql);
		$DB->commit();
		echo "{'Code':'00','FileSize':'".$fdata['num_size']."'}";
	} else {
		echo "{'Code':'40','Message':'File Not Found'}";
		//echo "{'Code':'40','Message':'".str_replace(array("'","\n"),array('"',''),$sql)."'}";
	}
}
?>