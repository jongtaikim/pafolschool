<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2008-11-24
* �ۼ���: ������
* ��   ��: ���� ����
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');

 $sql = "delete from TAB_MEMO where num_oid = $_OID and num_serial = '$num_serial'";

 if($DB->query($sql)){
 $DB->commit();
	
echo '<script>alert("��ҵǾ����ϴ�.");</script>';
echo "<meta http-equiv='Refresh' Content=\"0; URL='/memo.send_list'\">";

 }else{
WebApp::moveBack('ó���� ������ �߻��Ͽ����ϴ�.');
 }



?>