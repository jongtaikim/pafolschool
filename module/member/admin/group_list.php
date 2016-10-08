<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: member/admin/group_list.php
* �ۼ���: 2006-03-16
* �ۼ���: �̹���
* ��  ��: �߰��׷츮��Ʈ
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');

switch($REQUEST_METHOD) {
	case "GET":
		$sql = "SELECT * FROM ".TAB_GROUP." WHERE num_oid=$_OID";
        $data = $DB->sqlFetchAll($sql);

  
        $tpl->define('CONTENT','html/member/admin/group_list.htm');
        $tpl->assign(array(
            'LIST'			=>	$data
        ));
	break;
	case "POST":
		switch($_POST['mode']) {
            case 'add':
                $str_group_name = $_POST['str_group_name'];
                $sql = "SELECT /*+ INDEX_DESC (".TAB_GROUP." ".PK_TAB_GROUP.") */ STR_GROUP ".
                       "FROM ".TAB_GROUP." WHERE num_oid=$_OID AND rownum=1";
                $group = intval($DB->sqlFetchOne($sql)) + 1;
                $sql = "INSERT INTO ".TAB_GROUP." (num_oid,str_group,str_group_name) ".
                       "VALUES ($_OID,'$group','$str_group_name')";
                if(!$DB->query($sql)) WebApp::moveBack('Failed '.$DB->error['message']);
                $DB->commit();
                WebApp::moveBack('�߰� �Ǿ����ϴ�.');
                break;
            case 'modify':
                $str_group = $_POST['str_group'];
                $str_group_name = $_POST['str_group_name'];
                $sql = "UPDATE ".TAB_GROUP." SET str_group_name='$str_group_name' WHERE num_oid=$_OID AND str_group='$str_group'";
                if(!$DB->query($sql)) WebApp::moveBack('Failed '.$DB->error['message']);
                $DB->commit();
                WebApp::moveBack('���� �Ǿ����ϴ�.');
                break;
            case 'delete':
                $str_group = $_POST['str_group'];
                $sql = "DELETE FROM ".TAB_GROUP." WHERE num_oid=$_OID AND str_group='$str_group'";
                if(!$DB->query($sql)) WebApp::moveBack('Failed '.$DB->error['message']);

                $sql = "DELETE FROM ".TAB_GROUP_MEMBER." WHERE num_oid=$_OID AND str_group='$str_group'";
                if(!$DB->query($sql)) WebApp::moveBack('Failed '.$DB->error['message']);
                $DB->commit();

                WebApp::moveBack('���� �Ǿ����ϴ�.');
                break;
        }
	break;
}
?>