<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: module/admin/main/compose.php
* �ۼ���: 2006-01-16
* �ۼ���: ������
* ��  ��: ����ȭ��
*****************************************************************
* 
*/
switch (REQUEST_METHOD) {
	case 'GET':
		$tpl->setLayout('admin');
		$tpl->define('CONTENT', WebApp::getTemplate('admin/main/summary.htm'));
		break;
	case 'POST':
		break;
}

?>