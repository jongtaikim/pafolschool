<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: delete_check.php
* �ۼ���: 2005-07-21
* �ۼ���: �̹���
* ��  ��: �ߺ�Ȯ�� ����Ÿ(IP,ID)�� ����
*****************************************************************
* 
*/
if(!$id = $_REQUEST['id']) WebApp::raiseError('�߸��� ��û�Դϴ�.');
$DB = &WebApp::singleton('DB');

$sql = "DELETE FROM ".TAB_POLL_IP." WHERE NUM_OID=$OID AND NUM_MAIN=$id";
$DB->query($sql);
$DB->commit();

$sql = "DELETE FROM ".TAB_POLL_USER." WHERE NUM_OID=$OID AND NUM_MAIN=$id";
$DB->query($sql);
$DB->commit();

WebApp::redirect($URL->setVar(array('act'=>'.list','id'=>$id)), '�����Ǿ����ϴ�.');
?>