<?
/***********************************
*  lms ���� ī�װ�
*  �ۼ��� : ������
**********************************/



$DB = &WebApp::singleton("DB");



switch ($mode) {
	case "email":
	
	$email = $email1."@".$email2;
	$sql ="select count(*) from TAB_MEMBER where num_oid = ".$_OID." and str_email = '$email'";
	$chk = $DB->sqlFetchOne($sql);

	if($chk > 0) {
		echo "Y";
	}else{
		echo "N";
	}

	break;
}
?>
