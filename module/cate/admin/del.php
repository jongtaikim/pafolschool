<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/admin/menu/del.php
* 작성일: 2005-02-15
* 작성자: 이범민
* 설  명: 
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');
$mcode = $_REQUEST['mcode'];
$parent = substr($mcode,0,-2);
$data = $DB->sqlFetch("SELECT * FROM ".TAB_MENU." WHERE num_oid=$_OID AND num_mcode=$mcode");
list($module_name,$module_type) = explode('#',$str_type);
include 'module/'.$module_name.'/admin/__del.php';

if ($DB->query("DELETE FROM ".TAB_MENU." WHERE num_oid=$_OID AND num_mcode=$mcode")) $DB->commit();
if ($DB->query("DELETE FROM ".TAB_MENU_RIGHT." WHERE NUM_OID=$_OID AND NUM_MCODE=$mcode")) $DB->commit();

$FTP = &WebApp::singleton("FtpClient",WebApp::getConf('account'));
$FTP->delete($_DOC_ROOT.'/hosts/'.$HOST.'/menu.xml');
if(strlen($mcode)>2) $FTP->delete($_DOC_ROOT.'/hosts/'.$HOST.'/menu/'.substr($mcode,0,-2).'.htm');
$FTP->close();

echo "<script type='text/javascript'>
try {
	top.frames['menu'].tree.getSelected().parentNode.reload();
	top.frames['menu'].setSelected('$parent');
} catch(e) {
    alert('exception occured!!');
	//	nothing special
}
</script>";
WebApp::redirect("admin.menu.option?mcode=$parent");
?>
