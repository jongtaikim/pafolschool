<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: module/party/board/admin/__del.php
* �ۼ���: 2006-05-16
* �ۼ���: �̹���
* ��  ��: 
*****************************************************************
* 
*/
// ÷������ ����� ÷������ DB �ʱ�ȭ�ϱ�
include 'module/party/board/table_define.php';
$FH = &WebApp::singleton('FileHost','party',$pcode.'.'.$mcode);
$FH->delete_as_code($pcode.'.'.$mcode);

// ����� ����
$sql = "SELECT STR_THUMB FROM $ARTICLE_TABLE WHERE num_oid=$_OID AND num_pcode=$pcode AND num_mcode=$mcode AND str_thumb IS NOT NULL";
if($thumb_data = $DB->sqlFetchAll($sql)) {
	foreach($thumb_data as $row) $del_thumbs[] = $row['str_thumb'];
	$FH->del_thumb($del_thumbs);
}
$FH->close();

// �Խù� ���� �����
$DB->query("DELETE FROM TAB_PARTY_BOARD WHERE num_oid=$_OID AND num_pcode=$pcode AND num_mcode=$mcode");
$DB->commit();

// �Խù� Comment ����
$DB->query("DELETE FROM TAB_PARTY_BOARD_COMMENT WHERE num_oid=$_OID AND num_pcode=$pcode AND num_mcode=$mcode");
$DB->commit();

// �Խ��� ���� �����
$DB->query("DELETE FROM TAB_PARTY_BOARD_CONFIG WHERE num_oid=$_OID AND num_pcode=$pcode AND num_mcode=$mcode");
$DB->commit();

include 'module/party/board/admin/__init__.php';
updateConf($pcode,$mcode,$party_conf_file);
?>