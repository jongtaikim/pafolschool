<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2008-01-30
* �ۼ���: ������
* ��  ��: �����Ӹ�~!
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');
$sql = "SELECT * FROM TAB_FILES WHERE num_oid=$_OID AND str_code='$mcode' AND num_main=$id AND num_serial=$serial";

$data = $DB->sqlFetch($sql);

$filename = $data['str_upfile'];
$filepath = $data['str_refile'];
$filesize = $data['num_size'];

if ($DB->query("DELETE FROM TAB_FILES WHERE num_oid=$_OID AND  str_code='$mcode' AND num_main=$id AND num_serial=$serial")) {
	$DB->commit();
	
	$source_path = _DOC_ROOT."/hosts/".HOST."/board/".$data['str_refile'];
	unlink($source_path);

	$sql = "UPDATE TAB_BOARD SET  NUM_FILE=NUM_FILE-1 WHERE NUM_OID=$_OID AND NUM_MCODE=$mcode AND NUM_SERIAL=$main";
	if($DB->query($sql)) $DB->commit();
	WebApp::moveBack('�����Ǿ����ϴ�.');

} else {
	WebApp::moveBack('������ �������� ���߽��ϴ�');
}

?>