<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/party/board/admin/__add.php
* 작성일: 2006-05-16
* 작성자: 이범민
* 설  명: 
*****************************************************************
* 
*/
require_once 'module/party/board/table_define.php';
if(!$module_type) $module_type = 'B';
$listnum = ($module_type == 'B') ? 10 : 8;
$titlelen = ($module_type == 'B') ? 100 : 30;
$sql = "
	INSERT INTO $CONFIG_TABLE
		(num_oid, num_pcode, num_mcode, str_title, str_skin,
        chr_listtype, chr_oddcolor, chr_evencolor, chr_comment, chr_recent, chr_upload)
	VALUES
		($_OID, $pcode, $mcode, '$menu_name','board',
        '$module_type','#FFFFFF','#FFFFFF','Y','N', 'Y')
";



if ($DB->query($sql)) {
	$DB->commit();


} 

include 'module/party/board/admin/__init__.php';

$s_link = "party.board.list?pcode=$pcode&mcode=$mcode";

$sql = "
	update set $CONFIG_TABLE
		str_link = '$s_link'
	where num_oid = $_OID and pcode = '$pcode' and mcode = '$mcode'
";



$DB->query($sql);
	$DB->commit();
?>
