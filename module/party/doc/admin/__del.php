<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: module/party/doc/admin/__del.php
* �ۼ���: 2006-05-17
* �ۼ���: �̹���
* ��  ��: �������� �޴��� �����Ҷ� ó���� �׼�
*****************************************************************
* 
*/

$FH = &WebApp::singleton('FileHost');
$FH->set_code('party', $pcode.'.'.$mcode);
$FH->delete_as_code();

$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
$FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/doc/party.'.$pcode.'.'.$mcode.'.msg');
?>
