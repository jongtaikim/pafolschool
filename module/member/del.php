<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2008-09-23
* �ۼ���: ������
* ��  ��: ȸ�� Ż�� ������ ���j��
*****************************************************************
* 
*/

switch ($REQUEST_METHOD) {
	case "GET":
	
	$DOC_TITLE="str:ȸ��Ż���ϱ�";

	$tpl->setLayout();
	$tpl->define("CONTENT", Display::getTemplate("member/del.htm"));
	
	 break;
	case "POST":
	$DB = &WebApp::singleton('DB');

	if( $_SESSION[USERID] == "admin") {
	WebApp::moveBack('�峭ġ�� ������.');
	exit;
	}

	$sql = "select max(num_serial)+1 from TAB_MEMBER_DEL where num_oid = '$_OID' ";
	$max = $DB -> sqlFetchOne($sql);
	if(!$max) $max  = 1;
	
	

	$sql = "INSERT INTO ".TAB_MEMBER_DEL." 
	(num_oid, num_serial,str_id,str_title,str_text
		) VALUES 
	('$_OID', '$max','".$_SESSION[USERID]."','$str_title','$str_text') ";
	
	$DB->query($sql);
	$DB->commit();
				
	 $sql = "delete from  TAB_MEMBER where num_oid = '".$_OID."' and str_id = '".$_SESSION[USERID]."'";
	 $DB->query($sql);
	 $DB->commit();
	
	echo '<script>alert("���������� Ż�� �Ǿ����ϴ�.\n�����մϴ�.");</script>';
	echo "<meta http-equiv='Refresh' Content=\"0; URL='member.logout'\">";
	
	
	break;
	}

?>