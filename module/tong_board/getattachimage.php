<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: getattachimage.php
* �ۼ���: 2004-09-04
* �ۼ���: �̹���
* ��  ��: Content Image ���� URL ��û
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
	echo "alert('���������� �����Ͽ����ϴ�.');";
	exit;
}
$DB->commit();
echo "maxImageWidth=500;\n	setImage('http://$FILE_HOST/hosts/$_OID/board/$str_refile');";
exit;
?>