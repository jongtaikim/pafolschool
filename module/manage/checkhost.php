<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: module/manage/checkhost.php
* �ۼ���: 2006-04-13
* �ۼ���: �̹���
* ��  ��: ȣ��Ʈ�� �ߺ�üũ Response With JSON
*****************************************************************
* 
*/
header('Content-Type: text/html; charset=EUC-KR');
if(!$str_host = $_REQUEST['str_host']) {
    echo '{"Code":"44","Message":"ȣ��Ʈ���� �Է��Ͽ� �ֽʽÿ�"}';
} elseif(!ereg('^[0-9a-z-]{2,20}$',$str_host)) {
    echo '{"Code":"55","Message":"ȣ��Ʈ���� ����, ���� �ҹ��� ���� 2�� �̻� 20�� ���Ϸ� �Է��Ͽ� �ֽʽÿ�."}';
} else {
    $DB = &WebApp::singleton('DB');
    $sql = "SELECT COUNT(*) FROM ".TAB_ORGAN." WHERE str_host='".$str_host;
    if($DB->sqlFetchOne($sql)) {
        echo '{"Code":"66","Message":"ȣ��Ʈ���� �̹� ������Դϴ�."}';
    } else {
        echo '{"Code":"00","Message":"��밡���մϴ�."}';
    }
}
?>