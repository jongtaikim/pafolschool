<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2008-06-24
* �ۼ���: ������
* ��  ��: ����б� ���ο� �÷� ����
*****************************************************************
* 
*/
$DB = &WebApp::singleton("DB");


$sql = "update TAB_BOARD set str_main = '$str_main'  where num_oid = '$_OID' and num_mcode = $mcode and num_serial = $id";
$DB->query($sql);
$DB->commit();


if($str_main) {
WebApp::moveBack('�÷����� �����Ǿ����ϴ�.');	
}else{
WebApp::moveBack('�÷��� �����Ǿ����ϴ�.');
}





?>