<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2009-01-15
* �ۼ���: ������
* ��   ��: ī��ȸ�� �α���üũ(�׳� ��� ������)
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');

if(!$_SESSION["CAFELGNCHK".$pcode] && $_SESSION['USERID']){

	$_SESSION["CAFELGNCHK".$pcode] = true;

	$sql = "update TAB_PARTY_MEMBER set num_login=num_login+1 where num_oid=$_OID and num_pcode=$pcode and str_id='".$_SESSION['USERID']."'";
	$DB->query($sql);
	$DB->commit();

}

?>