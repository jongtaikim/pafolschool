<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: module/link/go.php
* �ۼ���: 2004-04-02
* �ۼ���: ��ģ����
* ��  ��: URL�� �����̷�Ʈ�����ִ� ���
*****************************************************************
* NOTE: DB�� �ѹ� �� �а� �����ٵ� �ٽ� �Ͼ�Ƿ�, ��������������� ����
*       ���۷��� ������ ����ϰ�Ͱų� ��Ÿ ������ ������� ���Ȯ���
*/

$mcode = $_REQUEST['mcode'];
$DB = &WebApp::singleton('DB');
$sql = "
    SELECT
        /* INDEX (TAB_CONTENT_URL PK_TAB_CONTENT_URL) */
        str_url, str_target
    FROM
        TAB_CONTENT_URL
    WHERE
        num_oid="._OID." AND num_mcode={$mcode}
";

$data = $DB->sqlFetch($sql);
WebApp::redirect($data['str_url']);
//TODO: target�� ����â�� �ƴѰ�쿡���� �׼��� ���⼭ �� ��������?    
?>
