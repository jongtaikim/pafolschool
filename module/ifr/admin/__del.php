<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: module/link/admin/__del.php
* �ۼ���: 2005-04-01
* �ۼ���: ��ģ����
* ��  ��: ��ũ�� �޴��� �����Ҷ� ȣ��Ǵ� ����
*****************************************************************
* 
*/

$DB = &WebApp::singleton('DB');
$sql = "
	DELETE FROM
        TAB_CONTENT_URL
    WHERE
        num_oid="._OID." AND num_mcode='{$mcode}'
";
$DB->query($sql);
$DB->commit();

?>
