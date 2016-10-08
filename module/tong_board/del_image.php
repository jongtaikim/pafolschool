<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: del_image.php
* 작성일: 2004-09-07
* 작성자: 이범민
* 설  명: Content에 포함된 이미지 삭제
*****************************************************************
* 
*/
//include "module/inc.file_ftp.conn.php";
include_once $APPPATH."/_file_ftp_conn.php";

if($fname) {
	$DB = &WebApp::singleton("DB");
	$_fname = explode("/",$fname);
	$str_refile = array_pop($_fname);
	$sql = "SELECT NUM_SERIAL FROM $FILE_TABLE WHERE NUM_OID=$_OID AND NUM_MCODE=$mcode AND STR_REFILE='$str_refile'";
	if($id = $DB->sqlFetchOne($sql)) {
		file_ftp_conn();
		$source_path = $FILE_FTP_ROOT."/hosts/$_OID/board/".$str_refile;
		$FILE_FTP->delete($source_path);
		$FILE_FTP->close();

		$sql = "DELETE FROM $FILE_TABLE WHERE NUM_OID=$_OID AND NUM_MCODE=$mcode AND NUM_SERIAL=$id";
		$DB->query($sql);
		$DB->commit();
	}
}
echo "<script>self.close();</script>";
exit;
?>