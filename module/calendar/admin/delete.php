<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: delete.php
* �ۼ���: 2005-03-18
* �ۼ���: �̹���
* ��  ��: 
*****************************************************************
* 
*/
if(!$id = $_REQUEST['id']) WebApp::moveBack('�߸��� ��û�Դϴ�.');
$DB = &WebApp::singleton('DB');
$FH = &WebApp::singleton('FileHost','main','calendar');

$sql = "SELECT str_text FROM ".TAB_CALENDAR." WHERE num_oid=$_OID AND num_serial=$id";
$str_text = $DB->sqlFetchOne($sql);

$sql = "DELETE FROM ".TAB_CALENDAR." WHERE NUM_OID=$_OID AND NUM_SERIAL=$id";
if($DB->query($sql)) {
	$DB->commit();
    $FH->delete_as_html($str_text);
	$FH->delete_as_main($id);
}
$FH->close();

$cache_file = _DOC_ROOT.'/hosts/'.HOST.'/'."inc.main.calendar.htm";
unlink($cache_file);

WebApp::redirect($URL->setVar(array('act'=>'.list','id'=>'','h'=>$f)),'�����Ǿ����ϴ�.');
?>