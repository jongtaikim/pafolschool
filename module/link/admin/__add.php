<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: module/link/admin/__add.php
* �ۼ���: 2005-04-01
* �ۼ���: ��ģ����
* ��  ��: ��ũ�� �޴��� �����Ҷ� ȣ��Ǵ� ����
*****************************************************************
* 
*/

$DB = &WebApp::singleton('DB');


$sql = "
    INSERT INTO TAB_CONTENT_URL
        (num_oid, num_mcode, str_title, str_url, str_target, dt_date)
    VALUES
        ("._OID.",{$mcode},'{$str_title}','#','_self',SYSDATE)
";
$DB->query($sql);
$DB->commit();

?>
