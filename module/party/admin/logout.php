<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: module/party/admin/logout.php
* �ۼ���: 2006-05-16
* �ۼ���: �̹���
* ��  ��: 
*****************************************************************
* 
*/
$_SESSION['ADMIN_PARTY_'.$pcode] = false;

@session_unregister('ADMIN_PARTY_'.$pcode);


	echo "<meta http-equiv='Refresh' Content=\"0; URL='party.board.list?pcode=$pcode'\">";

?>