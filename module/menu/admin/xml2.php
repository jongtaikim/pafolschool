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
$mcode = $_REQUEST['mcode'];

if ($mcode) {
	$sql = "SELECT * FROM ".TAB_MENU." WHERE num_oid=$_OID AND num_mcode LIKE '".$mcode."__' ORDER BY num_step";
} else {
	$sql = "SELECT * FROM ".TAB_MENU." WHERE num_oid=$_OID AND LENGTH(num_mcode)=2 ORDER BY num_step";
}
$data = $DB->sqlFetchAll($sql,OCI_ASSOC);
@array_walk($data,'cb_format_data');

$len = strlen($mcode);
$maxmenu = ($len > 1) ? 15 : 31;
if($mcode == 1) {
$enable_add = ($maxmenu > count($data));	
}


//if($enable_add && $len > 1) {
//    // 빈메뉴만 하위메뉴 구성 가능
//    $sql = "SELECT str_type FROM ".TAB_MENU." WHERE num_oid=$_OID AND num_mcode=$mcode";
//    $enable_add = ($DB->sqlFetchOne($sql) == 'menu');
//}

header('Content-type: text/xml');
header("Expires: ".gmdate("D, d M Y H:i:s")." GMT");
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");

echo '<?xml version="1.0" encoding="euc-kr"?'.'>';
$tpl->setLayout('blank');
$tpl->define('TREE',WebApp::getTemplate('menu/admin/xml.tpl'));
$tpl->assign('ITEM',&$data);
$tpl->assign(array(
    'parent'     => $mcode,
    'enable_add' => $enable_add
));
$tpl->print_('TREE');
exit;

// {{{  Functions
function cb_format_data(&$arr) {
	$DB = &WebApp::singleton('DB');
	$_OID = $arr['num_oid'];
	$sql = "SELECT COUNT(*) FROM ".TAB_MENU." WHERE num_oid=$_OID AND num_mcode LIKE '".$arr['num_mcode']."__'";
    if(strlen($arr['num_mcode']) < 6) $arr['submenu'] = 'src="menu.admin.xml?mcode='.$arr['num_mcode'].'"';
	//if ($DB->sqlFetchOne($sql) > 0) $arr['submenu'] = 'src="menu.admin.xml?mcode='.$arr['num_mcode'].'"';
	//else $arr['submenu'] = '';
    //if (empty($arr['submenu'])) {
        switch ($arr['str_type']) {
            case 'menu':
                $arr['icon'] = 'image/icon/file.png';
                break;
            case 'board#B':
                $arr['icon'] = 'image/icon/discuss.gif';
                break;
            case 'board#G':
                $arr['icon'] = 'image/icon/ai.gif';
                break;
			 case 'board#C':
                $arr['icon'] = 'image/icon/ai.gif';
                break;
            case 'council':
                $arr['icon'] = 'image/icon/eml.gif';
                break;
            case 'link':
                $arr['icon'] = 'image/icon/url.gif';
                break;
            case 'doc':
                $arr['icon'] = 'image/icon/html.png';
                break;
            default :
                $arr['icon'] = 'image/icon/default.gif';
                break;
        }
    //}

	$arr['str_title'] = htmlspecialchars($arr['str_title']);
}
// }}}


?>
