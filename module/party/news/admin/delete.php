<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: module/party/news/admin/delete.php
* �ۼ���: 2006-05-17
* �ۼ���: �̹���
* ��  ��: 
*****************************************************************
* 
*/
if(!$ids = $_REQUEST['ids']) WebApp::raiseError('�߸��� ��û�Դϴ�.');
$ids = explode(',',$ids);
$DB = &WebApp::singleton('DB');
$FH = &WebApp::singleton('FileHost','party',$pcode.'.news');
foreach($ids as $id) {
	if(!$id) continue;
	$sql = "SELECT str_text1,str_text2,str_text3 FROM ".TAB_PARTY_MAIN_BOARD." WHERE num_oid=$_OID AND num_pcode=$pcode AND num_serial=$id";
	$data = $DB->sqlFetch($sql);
	
	$sql = "DELETE FROM ".TAB_PARTY_MAIN_BOARD." WHERE num_oid=$_OID AND num_pcode=$pcode AND num_serial=$id";
	if($DB->query($sql)) {
		$DB->commit();
		$FH->delete_as_html($data['str_text1'].$data['str_text2'].$data['str_text3']);
		$FH->delete_as_main($id);
	}
}
$FH->close();

WebApp::redirect($URL->setVar(array('act'=>'.list','ids'=>'')),'�����Ǿ����ϴ�.');
?>