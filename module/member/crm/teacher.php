<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: module/member/crm/teacher.php
* �ۼ���: 2005-03-31
* �ۼ���: ��ģ����
* ��  ��: ����ȸ�� �߰����� �Է�â
*****************************************************************
* 
*/

switch (REQUEST_METHOD) {
	case 'GET':
		$tpl->setLayout('@sub');
		$tpl->define('CONTENT', Display::getTemplate('member/crm/teacher.htm'));
		break;
	case 'POST':
		break;
}
?>