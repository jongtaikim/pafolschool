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


function newStep($mcode) {
		global $pcode;
	$DB = &WebApp::singleton('DB');
	$_OID = WebApp::getConf('oid');
	$sql = "SELECT MAX(num_step) FROM ".TAB_MENU." WHERE num_oid=$_OID and num_pcode = $pcode AND num_mcode LIKE '".$mcode."__'";
	return $DB->sqlFetchOne($sql) + 1;
}
?>