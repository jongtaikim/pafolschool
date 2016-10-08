<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/admin/menu/tree.php
* 작성일: 2004-01-27
* 작성자: 거친마루
* 설  명: 메뉴트리 출력
*****************************************************************
* 
*/

$DB = &WebApp::singleton('DB');
$node = $_REQUEST['node'];

if ($node) {
	$len = strlen($node)+2;
	$sql = "SELECT * FROM ".TAB_MENU." WHERE num_oid=$_OID AND num_mcode LIKE '$node%' AND LENGTH(num_mcode)=$len ORDER BY num_step";
} else {
	$sql = "SELECT * FROM ".TAB_MENU." WHERE num_oid=$_OID AND LENGTH(num_mcode)=2 ORDER BY num_step";
}
$data = $DB->sqlFetchAll($sql,OCI_ASSOC);
@array_walk($data,'cb_format_data');

header('Content-type: text/xml');
header("Expires: ".gmdate("D, d M Y H:i:s")." GMT");
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");

echo '<?xml version="1.0" encoding="euc-kr"?>';
$tpl->setLayout('blank');
$tpl->define('TREE',WebApp::getTemplate('menu/admin/xml.tpl'));
$tpl->assign('ITEM',&$data);
$tpl->assign('parent',$node);
$tpl->print_('TREE');
exit;

// {{{  Functions
function cb_format_data(&$arr) {
	$DB = &WebApp::singleton('DB');
	$_OID = $arr['num_oid'];
	$parent = $arr['num_mcode'];
    $arr['maxmenu'] = ($parent) ? 15 : 10;
	$len = strlen($parent) + 2;
	$sql = "SELECT COUNT(*) FROM ".TAB_MENU." WHERE num_oid=$_OID AND num_mcode LIKE '$parent%' AND LENGTH(num_mcode)=$len";
	if ($DB->sqlFetchOne($sql) > 0) $arr['submenu'] = 'src="menu.admin.xml?node='.$parent.'"';
	else $arr['submenu'] = '';
    if (empty($arr['submenu'])) {
//        $arr['icon'] = WebApp::get($arr['str_type'],'icon',$arr['str
        switch ($arr['str_type']) {
            case 'menu':
                $arr['icon'] = 'image/icon/folder.png';
                break;
            case 'board#B':
                $arr['icon'] = 'image/icon/discuss.gif';
                break;
            case 'board#G':
                $arr['icon'] = 'image/icon/ai.gif';
                break;
            default:
                $arr['icon'] = 'image/icon/html.png';
        }
    }

	$arr['str_title'] = htmlspecialchars($arr['str_title']);
}
// }}}

?>
