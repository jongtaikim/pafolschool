<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: delete.php
* �ۼ���: 2005-03-24
* �ۼ���: �̹���
* ��  ��: 
*****************************************************************
* 
*/
if(!$ids = $_REQUEST['ids']) WebApp::raiseError('�߸��� ��û�Դϴ�.');
$ids = explode(',',$ids);
$DB = &WebApp::singleton('DB');
$FH = &WebApp::singleton('FileHost','main',$code);
foreach($ids as $id) {
	if(!$id) continue;
	$sql = "SELECT STR_TEXT1,STR_TEXT2,STR_TEXT3 FROM ".TAB_POPUP." WHERE NUM_OID=$_OID AND NUM_SERIAL=$id";
	$data = $DB->sqlFetch($sql);
	$sql = "DELETE FROM ".TAB_POPUP." WHERE NUM_OID=$_OID AND NUM_SERIAL=$id";
	if($DB->query($sql)) {
		$DB->commit();
		$FH->delete_as_html($data['str_text1'].$data['str_text2'].$data['str_text3']);
		$FH->delete_as_main($id);
	}
}
$FH->close();

// ĳ������
$FTP = &WebApp::singleton("FtpClient",WebApp::getConf("account"));
$FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/files/popup/popup.js');
$FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/files/popup/popup'.$id.'.htm');
$FTP->close();

WebApp::moveBack('�����Ǿ����ϴ�.');
?>