<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: __init__.php
* �ۼ���: 2004-10-16
* �ۼ���: �̹���
* ��  ��: 
*****************************************************************
* 
*/

// 2���� Ȩ�������� ��ϴ°�� ȸ������ ������ ���� oid ����(2004-10-16)
if($member_alias_oid = WebApp::getConf("member_alias_oid")) {
	$oid = $member_alias_oid;
}

$oid = _OID;

?>