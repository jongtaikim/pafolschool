<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: module/party/council/admin/__add.php
* �ۼ���: 2006-05-17
* �ۼ���: �̹���
* ��  ��: 
*****************************************************************
* 
*/
$DB->query("
	INSERT INTO ".TAB_PARTY_COUNCIL_CONFIG."
		(num_oid, num_pcode, num_mcode, str_title, str_skin, chr_oddcolor, chr_evencolor, chr_upload)
	VALUES
		($_OID, $pcode, $mcode, '$menu_name','default','#FFFFFF','#FFFFFF', 'Y')
");
if (!$DB->error) {
	$DB->commit();
    include 'module/party/council/admin/__init__.php';
    updateConf($pcode,$mcode,$party_conf_file);
} else {
	WebApp::raiseError('���� �޴� ������ ������ �߻��߽��ϴ�.');
}
?>
