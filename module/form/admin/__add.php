<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2009-07-29
* 작성자: 김종태
* 설  명: 
*****************************************************************
* 
*/

$sql = "
	INSERT INTO TAB_FORM_CSS
		(num_oid, num_mcode, str_skin,str_title,dt_date)
	VALUES
		($_OID, $mcode, 'table02','$menu_name',".mktime().")
";
if ($DB->query($sql)) {
	$DB->commit();
} 
?>
