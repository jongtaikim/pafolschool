<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: module/party/link/admin/edit.php
* �ۼ���: 2006-05-17
* �ۼ���: �̹���
* ��  ��: 
*****************************************************************
* 
*/

$DB = &WebApp::singleton('DB');
$mcode = $_REQUEST['mcode'];

switch (REQUEST_METHOD) {
    case 'GET':
        $sql = "SELECT str_title, str_link,str_target FROM ".TAB_PARTY_MENU." ".
               "WHERE num_oid="._OID." AND num_pcode=$pcode AND num_mcode='{$mcode}'";
        $data = $DB->sqlFetch($sql);
        $data['mcode'] = $mcode;

        $tpl->setLayout('admin');
        $tpl->define('CONTENT', 'html/party/link/admin/edit.htm');
        $tpl->assign($data);
        break;
    case 'POST':
        $str_title = $_POST['str_title'];
        $str_link = $_POST['str_link'];
        $str_target = $_POST['str_target'];

        $sql = "
            UPDATE ".TAB_PARTY_MENU." SET
                str_title='$str_title', str_link='$str_link', str_target='$str_target'
            WHERE
                num_oid="._OID." AND num_pcode=$pcode AND num_mcode='$mcode'
        ";
        if ($DB->query($sql)) {
            $DB->commit();

            WebApp::moveBack();
        } else {
            WebApp::raiseError('��ũ�� URL�� ������ �� �����ϴ�');
        }
        break;
}
?>