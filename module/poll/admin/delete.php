<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: delete.php
* �ۼ���: 2005-07-21
* �ۼ���: �̹���
* ��  ��: ��������
* [����] 2007-05-23 (��)���̳�ũ �����
*****************************************************************
* 
*/


if(!is_array($_REQUEST['ids'])) $_REQUEST['ids']=$_REQUEST['id'];

if(!$ids = $_REQUEST['ids'] || !is_array($ids)) WebApp::raiseError('�߸��� ��û�Դϴ�.');

// 2007-05-23 (��)���̳�ũ �����
$ids = $_REQUEST['ids'];

$DB = &WebApp::singleton('DB');
$sqls = array(
"DELETE FROM ".TAB_POLL_CONTENTS." WHERE NUM_OID=$_OID AND NUM_MAIN=",
"DELETE FROM ".TAB_POLL_COMMENT." WHERE NUM_OID=$_OID AND NUM_MAIN=",
"DELETE FROM ".TAB_POLL_IP." WHERE NUM_OID=$_OID AND NUM_MAIN=",
"DELETE FROM ".TAB_POLL_USER." WHERE NUM_OID=$_OID AND NUM_MAIN=",
"DELETE FROM ".TAB_POLL_MAIN." WHERE NUM_OID=$_OID AND NUM_SERIAL="
);

// 2007-05-23 (��)���̳�ũ �����
if(!is_array($ids)) $ids=array($ids);
foreach($ids as $id) {
	foreach($sqls as $sql) {
		$DB->query($sql.$id);
    $DB->commit();
	}
}

// ĳ�� ����
$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
$FTP->delete(_DOC_ROOT.'/'.$cache_file);
$FTP->close();

WebApp::redirect($URL->setVar(array('act'=>'.list','id'=>'')));
?>