<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: module/member/crm/student.php
* �ۼ���: 2005-03-31
* �ۼ���: ��ģ����
* ��  ��: �л�ȸ�� �߰����� �Է�â
*****************************************************************
* 
*/

switch (REQUEST_METHOD) {
	case 'GET':
		$tpl->setLayout('@sub');
		$tpl->define('CONTENT', Display::getTemplate('member/crm/student.htm'));
		break;
	case 'POST':
		break;
}
?>