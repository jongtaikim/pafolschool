<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: module/admin/menu/reset.php
* �ۼ���: 2005-02-15
* �ۼ���: �̹���
* ��  ��: 
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');
$mcode = $_REQUEST['mcode'];
$parent = substr($mcode,0,-2);
$data = $DB->sqlFetch("SELECT * FROM ".TAB_MENU." WHERE num_oid=$_OID AND num_mcode=$mcode");
if(!$data['num_enable_remove']) WebApp::moveBack('������ �� ���� �޴��Դϴ�.');

list($module_name,$module_type) = explode('#',$data['str_type']);
include 'module/'.$module_name.'/__del.php';

if ($DB->query("UPDATE ".TAB_MENU." SET str_type='menu' WHERE num_oid=$_OID AND num_mcode=$mcode")) $DB->commit();
if ($DB->query("DELETE FROM ".TAB_MENU_RIGHT." WHERE num_oid=$_OID AND str_sect='menu' AND str_code='$mcode'")) $DB->commit();

exec("rm -rf "._DOC_ROOT.'/hosts/'.HOST.'/'."inc_menu/*.htm");

echo "<script>
try {
	top.frames['menu'].reloadSelected();
	top.frames['menu'].setSelected('$mcode');
} catch(e) {
	//	nothing special
}
</script>";
WebApp::redirect($URL->setVar(array('act' => '.option','mcode'=>$mcode)));

?>
