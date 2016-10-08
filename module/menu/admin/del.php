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
if(!$data['num_enable_remove']) WebApp::moveBack('삭제할 수 없는 메뉴입니다.');

list($module_name,$module_type) = explode('#',$data['str_type']);
include 'module/'.$module_name.'/admin/__del.php';

if ($DB->query("DELETE FROM ".TAB_MENU." WHERE num_oid=$_OID AND num_mcode=$mcode")) $DB->commit();
if ($DB->query("DELETE FROM ".TAB_MENU_RIGHT." WHERE num_oid=$_OID AND str_sect='menu' AND str_code='$mcode'")) $DB->commit();

deleteCacheFiles($mcode);

 echo "<script type='text/javascript'>
            try {
                parent.frames['menu'].reloadParent();
                parent.frames['menu'].setSelected('{$parent}');
            } catch(e) {
                //  nothing special
            }
            </script>";
WebApp::redirect("menu.admin.listorder?mcode=".$parent);

exec("rm -rf "._DOC_ROOT.'/hosts/'.HOST.'/'."inc_menu/*.htm");
?>
