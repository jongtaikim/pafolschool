<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: module/news/admin/delete.php
* �ۼ���: 2005-03-23
* �ۼ���: �̹���
* ��  ��: 
*****************************************************************
* 
*/
$_OID2 = "1";
if(!$ids = $_REQUEST['ids']) WebApp::raiseError('�߸��� ��û�Դϴ�.');
$ids = explode(',',$ids);
$DB = &WebApp::singleton('DB');
$FH = &WebApp::singleton('FileHost','main','news.'.$code);
foreach($ids as $id) {
	if(!$id) continue;
	$sql = "SELECT STR_TEXT1,STR_TEXT2,STR_TEXT3,STR_THUMB FROM ".TAB_MAIN_BOARD." WHERE NUM_OID=$_OID2 AND STR_CODE='$code' AND NUM_SERIAL=$id";
	$data = $DB->sqlFetch($sql);
	
	$sql = "DELETE FROM ".TAB_MAIN_BOARD." WHERE NUM_OID=$_OID2 AND STR_CODE='$code' AND NUM_SERIAL=$id";
	if($DB->query($sql)) {
		$DB->commit();
		$FH->delete_as_html($data['str_text1'].$data['str_text2'].$data['str_text3']);
		$FH->delete_as_main($id);
		if($data['str_thumb']) $FH->del_thumb($data['str_thumb'],$conf['thumb_width']);
	}
}
$FH->close();

// ĳ������
$FTP = &WebApp::singleton("FtpClient",WebApp::getConf("account"));
$FTP->delete(_DOC_ROOT.'/'.$cache_file);
$FTP->close();

WebApp::redirect($URL->setVar(array('act'=>'.list','ids'=>'')),'�����Ǿ����ϴ�.');
?>