<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: member/admin/crossuser.php
* �ۼ���: 2008-11-28
* �ۼ���: ������
* ��  ��: �ҷ�ȸ��(IP)����
*****************************************************************
* 
*/

switch($REQUEST_METHOD) {
	case "GET":
		
		if(!$id){
			WebApp::moveBack("Error!!!");
			exit;
		}

		$sql = "delete from TAB_CROSSUSER where num_oid=$_OID and num_serial=$id";
		if($DB->query($sql)){
			$DB->commit();

			echo "<script>alert('�����Ǿ����ϴ�.');</script>";
			echo "<meta http-equiv='Refresh' Content=\"0; URL='/member.admin.crossuser'\">";
		}else{
			WebApp::moveBack("Error!!!");
		}


	break;
	case "POST":

	break;
}
?>
