<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: getattachimage.php
* 작성일: 2004-09-04
* 작성자: 이범민
* 설  명: Content Image 파일 URL 요청
*****************************************************************
* 
*/
include "module/inc.file_ftp.conn.php";
$DB = &WebApp::singleton("DB");
$sql = "SELECT /*+ INDEX_DESC($FILE_TABLE PK_$FILE_TABLE) */ NUM_SERIAL FROM $FILE_TABLE WHERE NUM_OID=$_OID AND NUM_MCODE=$code AND NUM_MAIN=-2 AND STR_REFILE='$phpsessid'";
$id = $DB->sqlFetchOne($sql);
$str_refile = "$code.-1.$id.$timestamp";
$sql = "UPDATE $FILE_TABLE SET STR_REFILE='$str_refile' WHERE NUM_OID=$_OID AND NUM_MCODE=$code AND NUM_MAIN=-2 AND NUM_SERIAL=$id";
file_ftp_conn();
if(!$DB->query($sql)) {
	$source_path = $FILE_FTP_ROOT."/hosts/$_OID/board/".$str_refile;
	$FILE_FTP->delete($source_path);
	$sql = "DELETE FROM $FILE_TABLE WHERE NUM_OID=$_OID AND NUM_MCODE=$code AND NUM_MAIN=-2 AND NUM_SERIAL=$id";
	$DB->query($sql);
	$DB->commit();
	echo "alert('파일저장이 실패하였습니다.');";
	exit;
}
$DB->commit();
echo "maxImageWidth=500;\n	setImage('http://$FILE_HOST/hosts/$_OID/board/$str_refile');";
exit;
?>