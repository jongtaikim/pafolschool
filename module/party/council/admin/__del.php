<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: module/party/council/admin/__del.php
* �ۼ���: 2006-05-12
* �ۼ���: �̹���
* ��  ��: 
*****************************************************************
* 
*/
// ÷������ ����� ÷������ DB �ʱ�ȭ�ϱ�
$FH = &WebApp::singleton('FileHost','party',$pcode.'.'.$mcode);
$FH->delete_as_code('party',$pcode.'.'.$mcode);
$FH->close();
unset($FH);

// �Խù� ���� �����
$DB->query("DELETE FROM ".TAB_PARTY_COUNCIL." WHERE num_oid=$_OID AND num_pcode=$pcode AND num_mcode=$mcode");
$DB->commit();

// �Խ��� ���� �����
$DB->query("DELETE FROM ".TAB_PARTY_COUNCIL_CONFIG." WHERE num_oid=$_OID AND num_pcode=$pcode AND num_mcode=$mcode");
$DB->commit();

include 'module/party/council/admin/__init__.php';
updateConf($pcode,$mcode,$party_conf_file);
?>