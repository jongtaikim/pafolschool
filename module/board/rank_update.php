<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2008-06-24
* �ۼ���: ������
* ��  ��:  ��õ
*****************************************************************
* 
*/
if(!$_SESSION['USERID']) {
WebApp::moveBack('�α����� �ʿ��մϴ�.');	
exit;
}

if($_SESSION['USERID'] == $user_id) {
WebApp::moveBack('�ڽ��� ���� ��õ�� �� �����ϴ�.');	
exit;
}


if(strstr($_SESSION['S_MCODE'],$mcode."|".$id)) {
WebApp::moveBack('�̹� ��õ�� ���Դϴ�.');	
exit;
}


$DB = &WebApp::singleton("DB");

$sql = "update TAB_BOARD set num_rank = num_rank +1  where num_oid = '$_OID' and num_mcode = $mcode and num_serial = $id";
$DB->query($sql);
$DB->commit();

$_SESSION['S_MCODE'] .= $mcode."|".$id;


WebApp::moveBack('��õ�Ǿ����ϴ�.');	






?>