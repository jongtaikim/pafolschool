<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: module/party/menu/admin/listorder.php
* �ۼ���: 2006-05-16
* �ۼ���: �̹���
* ��  ��: ��������
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');

switch($REQUEST_METHOD) {
	case "GET":
        $sql = "SELECT num_mcode,str_title FROM ".TAB_PARTY_MENU." WHERE num_oid=$_OID AND num_pcode=$pcode ORDER BY num_step";
        $list = $DB->sqlFetchAll($sql);


		$tpl->setLayout('admin');
        $tpl->define('CONTENT','html/party/menu/admin/listorder.htm');
        $tpl->assign(array(
            'mcode' =>  $mcode,
            'LIST'  =>  $list
        ));
	break;
	case "POST":
		$mcodes = $_POST['mcodes'];
        foreach ($mcodes as $mcode) {
            $i++;
            $DB->query("UPDATE ".TAB_PARTY_MENU." SET num_step=$i WHERE num_oid=$_OID AND num_pcode=$pcode");
        }
        if (!$DB->error) {
            $DB->commit();
            
            echo '<script type="text/javascript">parent.frames["padmin_menu"].reloadSelected();</script>';
            WebApp::moveBack();
        } else {
            $errors = $DB->error;
            WebApp::moveBack("<!> �޴� ������ �������� ���߽��ϴ�.\n�ڵ�: $errors[code]\n����: $errors[message]\n����: $errors[sqltext]");
        }
	break;
}
?>