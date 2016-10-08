<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/party/admin/logout.php
* 작성일: 2006-05-16
* 작성자: 이범민
* 설  명: 
*****************************************************************
* 
*/
$_SESSION['ADMIN_PARTY_'.$pcode] = false;

@session_unregister('ADMIN_PARTY_'.$pcode);


	echo "<meta http-equiv='Refresh' Content=\"0; URL='party.board.list?pcode=$pcode'\">";

?>