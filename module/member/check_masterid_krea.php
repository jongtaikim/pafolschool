<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: member/check_masterid.php
* �ۼ���: 2006-03-08
* �ۼ���: �̹���
* ��  ��: tab_member���� �ߺ����� üũ
*****************************************************************
* 
*/
$JSON = WebApp::singleton('JSON');
$id = $_REQUEST['id'];




    $except_id = array(
        'guest','admin','kt','file','host','hosts','list','podo','asdf','search','master','tweb',
        'email','mail','ns','mx','find','book','bookmart','podoweb','test','drbum','jsseo','cis');

    $DB = &WebApp::singleton('DB');
    $sql = "SELECT COUNT(*) FROM ".TAB_MEMBER." WHERE  num_oid = '"._OID."' and str_id='$id'";
    $count = $DB->sqlFetchOne($sql);
	
	//2009-02-23 ���� ��������� ����
    $sql = "SELECT COUNT(*) FROM ".TAB_WMV_USER." WHERE  num_oid = '"._OID."' and str_id='$id'";
    $count2 = $DB->sqlFetchOne($sql);

    header('Content-Encoding: cp949');
    if ($count2 ||$count || in_array($id,$except_id)) {
        $ret = array(
            'Code' => '99',
            'Message' => 'ID�� �����մϴ�'
        );
    } else {
        $ret = array(
            'Code' => '00',
            'Message' => '��� �����մϴ�'
        );
    }

echo $JSON->encode($ret);
?>