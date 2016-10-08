<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/board/admin/add.php
* 작성일: 2005-03-28
* 작성자: 이범민
* 설  명: 
*****************************************************************
* 
*/
require_once 'module/board/table_define.php';
if(!$module_type) $module_type = 'B';
$listnum = 20;
$titlelen = ($module_type == 'B') ? 100 : 30;

	//$sql = "delete from TAB_BOARD_CONFIG where num_oid = "._OID." and num_mcode = $mcode";
	//$DB->query($sql);
	

switch ($module_type) {
	case "B":
	
	$sql = "
	INSERT INTO $CONFIG_TABLE
		(num_oid, num_mcode, str_title, str_skin, num_listnum, num_navnum,
		num_titlelen, chr_listtype, chr_oddcolor, chr_evencolor, chr_comment, chr_recent)
	VALUES
		($_OID, $mcode, '$menu_name','B_board',$listnum,10,
		$titlelen,'$module_type','#FFFFFF','#FFFFFF','Y','N')
	";

	$DB->query($sql);

	 break;
	case "G":

		
	$sql = "
	INSERT INTO $CONFIG_TABLE
		(num_oid, num_mcode, str_title, str_skin, num_listnum, num_navnum,
		num_titlelen, chr_listtype, chr_oddcolor, chr_evencolor, chr_comment, chr_recent)
	VALUES
		($_OID, $mcode, '$menu_name','B_board',$listnum,10,
		$titlelen,'$module_type','#FFFFFF','#FFFFFF','Y','N')
	";


	$DB->query($sql);


	 break;


	}

	$DB->commit();

?>
