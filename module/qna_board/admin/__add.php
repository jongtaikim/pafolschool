<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: module/board/admin/add.php
* �ۼ���: 2005-03-28
* �ۼ���: �̹���
* ��  ��: 
*****************************************************************
* 
*/
require_once 'module/board/table_define.php';
if(!$module_type) $module_type = 'B';
$listnum = ($module_type == 'B') ? 10 : 8;
$titlelen = ($module_type == 'B') ? 100 : 30;
$sql = "DELETE FROM $CONFIG_TABLE WHERE num_oid=$_OID AND num_mcode=$mcode";
$DB->query($sql);

if(!$str_skin) $str_skin="A_board";

$sql = "
	INSERT INTO $CONFIG_TABLE
		(num_oid, num_mcode, str_title, str_skin, num_listnum, num_navnum,
		num_titlelen, chr_listtype, chr_oddcolor, chr_evencolor, chr_comment, chr_recent)
	VALUES
		($_OID, $mcode, '$menu_name','$str_skin',$listnum,10,
		$titlelen,'D','#FFFFFF','#FFFFFF','Y','N')
";
if ($DB->query($sql)) {
	$DB->commit();
} else {
	WebApp::raiseError('�Խ��� ������ ������ �߻��߽��ϴ�.');
}
?>
