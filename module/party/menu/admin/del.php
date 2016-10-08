<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/party/menu/admin/del.php
* 작성일: 2006-05-16
* 작성자: 이범민
* 설  명: 
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');
$mcode = $_REQUEST['mcode'];
$data = $DB->sqlFetch("SELECT * FROM ".TAB_PARTY_MENU." WHERE num_oid=$_OID AND num_pcode=$pcode AND num_mcode=$mcode");
list($module_name,$module_type) = explode('#',$data['str_type']);
include 'module/party/'.$module_name.'/admin/__del.php';

if ($DB->query("DELETE FROM ".TAB_PARTY_MENU." WHERE num_oid=$_OID  AND num_pcode=$pcode AND num_mcode=$mcode")) $DB->commit();
if ($DB->query("DELETE FROM ".TAB_MENU_RIGHT." WHERE num_oid=$_OID AND str_sect='party' AND str_code='".$pcode.".".$mcode."'")) $DB->commit();

echo "<script type='text/javascript'>
try {
    top.frames['padmin_menu'].reloadParent();
} catch(e) {
	//	nothing special
}
</script>";
WebApp::redirect("party.menu.admin.listorder?pcode=$pcode");
?>
