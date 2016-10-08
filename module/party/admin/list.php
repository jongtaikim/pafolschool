<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: module/party/admin/list.php
* �ۼ���: 2006-05-16
* �ۼ���: �̹���
* ��  ��: ���Ƹ� ��� �� ��������
*****************************************************************
* 
*/
include_once 'module/admin/__init__.php';
$DB = &WebApp::singleton('DB');

switch($REQUEST_METHOD) {
	case "GET":
        $sql = "SELECT * FROM ".TAB_PARTY." WHERE num_oid=$_OID and str_type='cafe' ORDER BY num_step";
        $data = $DB->sqlFetchAll($sql);

        $tpl->setLayout('no3');
        $tpl->define('CONTENT','html/party/admin/list.htm');
        $tpl->assign('LIST',$data);
	break;
	case "POST":
		if($pcodes = $_POST['pcodes']) {
            $step = 10;
            foreach($pcodes as $pcode) {
                if(!$pcode) continue;
                $sql = "UPDATE ".TAB_PARTY." SET num_step=".($step++)." WHERE num_oid=$_OID AND num_pcode=$pcode";
                $DB->query($sql);
            }
            $DB->commit();
        }
        WebApp::moveBack();
	break;
}
?>