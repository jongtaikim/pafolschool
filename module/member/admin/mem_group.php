<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: member/admin/mem_group.php
* �ۼ���: 2006-03-17
* �ۼ���: �̹���
* ��  ��: ȸ�� �׷��Ҵ�
*****************************************************************
* 
*/
if (!$id = $_REQUEST['id']) {
    WebApp::alert('�߸��� ��û�Դϴ�.');
    WebApp::closeWin();
}
$DB = &WebApp::singleton('DB');

switch($REQUEST_METHOD) {
	case "GET":
        $sql = "SELECT str_name FROM ".TAB_MEMBER." WHERE num_oid=$_OID AND str_id='$id'";
        $mem_name = $DB->sqlFetchOne($sql);
        $sql = "SELECT * FROM ".TAB_GROUP." WHERE num_oid=$_OID";
        $groups = $DB->sqlFetchAll($sql);
        $sql = "SELECT str_group FROM ".TAB_GROUP_MEMBER." WHERE num_oid=$_OID AND str_id='$id'";
        $data = $DB->sqlFetchAll($sql);

		$tpl->setLayout('admin');
        $tpl->define('CONTENT','html/member/admin/mem_group.htm');
        $tpl->assign(array(
            'GROUPS'    =>  $groups,
            'DATA'      =>  $data,
            'mem_name'  =>  $mem_name,
            'id'        =>  $id
        ));
	break;
	case "POST":
        $sql = "DELETE FROM ".TAB_GROUP_MEMBER." WHERE num_oid=$_OID AND str_id='$id'";
        $DB->query($sql);

		$groups = $_POST['groups'];

        foreach($groups as $group => $value) {
            $sql = "INSERT INTO ".TAB_GROUP_MEMBER." (num_oid,str_id,str_group) ".
                   "VALUES ($_OID,'$id','$group')";
            $DB->query($sql);
			$group_all .= $group."|";
		}
		$DB->commit();

		$sql = "UPDATE ".TAB_MEMBER." SET str_group='$group_all' WHERE num_oid=$_OID AND str_id='$id'";
		$DB->query($sql);
		$DB->commit();

        WebApp::alert('����Ǿ����ϴ�.');
        WebApp::closeWin();
	break;
}
?>