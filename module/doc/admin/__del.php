<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: module/doc/admin/__del.php
* �ۼ���: 2005-04-01
* �ۼ���: ��ģ����
* ��  ��: �������� �޴��� �����Ҷ� ó���� �׼�
*****************************************************************
* 
*/

$FH = &WebApp::singleton('FileHost', 'menu', $mcode);
$FH->delete_as_main($mcode);

$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
$FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/doc/'.$fcode.'.'.$mcode.'.msg');
?>
