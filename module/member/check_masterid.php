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

//if(!ereg('^[a-z]{1}[0-9a-z]{4,9}$',$id)) {
//2009-03-19 ���� �������ո��� ����
if(!ereg('^[0-9a-z]{3,10}$',$id)) {
    $ret = array(
        'Code' => '98',
        'Message' => '���� �ҹ��ڳ� ���ڷ� 3�ڸ� �̻� 10�ڸ� ���Ϸ� �Է��Ͽ��ֽʽÿ�.!!'
    );
} else {


    $except_id = array(
        'guest','admin','kt','file','host','hosts','list','podo','asdf','search','master','tweb',
        'email','mail','ns','mx','find','book','bookmart','podoweb','test','drbum','jsseo','cis','iadmin','sadmin');

    $DB = &WebApp::singleton('DB');
    $sql = "SELECT COUNT(*) FROM ".TAB_MEMBER." WHERE  num_oid = '"._OID."' and str_id='$id'";
    $count = $DB->sqlFetchOne($sql);

    header('Content-Encoding: cp949');
    if ($count || in_array($id,$except_id)) {
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
}
echo $JSON->encode($ret);
?>