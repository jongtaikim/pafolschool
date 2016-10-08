<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/party/menu/admin/reset.php
* 작성일: 2006-05-16
* 작성자: 이범민
* 설  명: 
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');
$mcode = $_REQUEST['mcode'];

list($module_name,$module_type) = explode('#',$data['str_type']);
include 'module/'.$module_name.'/__del.php';

$sql = "UPDATE ".TAB_PARTY_MENU." SET ".
       "str_type='menu', str_link='javascript:void(0);', str_target='_self' ".
       "WHERE num_oid=$_OID AND num_pcode=$pcode AND num_mcode=$mcode";
if ($DB->query($sql)) $DB->commit();
if ($DB->query("DELETE FROM ".TAB_MENU_RIGHT." WHERE NUM_OID=$_OID AND str_sect='party' AND str_code='".$pcode.".".$mcode."'")) $DB->commit();

echo "<script>
try {
	top.frames['padmin_menu'].reloadSelected();
} catch(e) {
	//	nothing special
}
</script>";
WebApp::redirect($URL->setVar(array('act' => '.option','mcode'=>$mcode)));
?>
