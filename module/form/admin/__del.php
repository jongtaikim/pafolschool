<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2009-07-29
* 작성자: 김종태
* 설  명: 몰라임마~!
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');
$sql = "delete from TAB_FORM_CSS where num_oid = "._OID." and num_mcode = ".$mcode."";
$DB->query($sql);
$sql = "delete from TAB_FORM where num_oid = "._OID." and num_mcode = ".$mcode."";
 $DB->query($sql);

$sql = "delete from TAB_FORM_CONFIG where num_oid = "._OID." and num_mcode = ".$mcode."";
 $DB->query($sql);
 $DB->commit();



?>