<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: member/joined.php
* �ۼ���: 2005-11-28
* �ۼ���: �̹���
* ��  ��: ȸ������ Ȯ�� ������
*****************************************************************
* 
*/
switch($REQUEST_METHOD) {
	case "GET":
		$tpl->setLayout('@sub2');
		$tpl->define('CONTENT',Display::getTemplate('member/joined.htm'));
	break;
	case "POST":
		
	break;
}
?>