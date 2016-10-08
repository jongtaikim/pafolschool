<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/party/menu/admin/xml.php
* 작성일: 2006-05-16
* 작성자: 이범민
* 설  명: 메뉴트리 출력
*****************************************************************
* 
*/

$DB = &WebApp::singleton('DB');
$mcode = $_REQUEST['mcode'];

$sql = "SELECT * FROM ".TAB_PARTY_MENU." WHERE num_oid=$_OID AND num_pcode=$pcode ORDER BY num_step";
$DB->query($sql);


$row = $DB -> sqlFetchAll($sql);


for($ii=0; $ii<count($row); $ii++) {
	
	switch ($row[$ii]['str_type']) {
        case 'menu':
            $row[$ii]['icon'] = 'image/icon/file.png';
            break;
        case 'board#B':
            $row[$ii]['icon'] = 'image/icon/discuss.gif';
            break;
        case 'board#G':
            $row[$ii]['icon'] = 'image/icon/ai.gif';
            break;
        case 'council':
            $row[$ii]['icon'] = 'image/icon/eml.gif';
            break;
        case 'link':
            $row[$ii]['icon'] = 'image/icon/url.gif';
            break;
        case 'doc':
            $row[$ii]['icon'] = 'image/icon/html.png';
            break;
        default :
            $row[$ii]['icon'] = 'image/icon/default.gif';
            break;
    }
	$row[$ii]['str_title'] = htmlspecialchars($row[$ii]['str_title']);

}

//$data = $DB->sqlFetchAll($sql,OCI_ASSOC);
//@array_walk($data,'cb_format_data');

header('Content-type: text/xml');
header("Expires: ".gmdate("D, d M Y H:i:s")." GMT");
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");

echo '<?xml version="1.0" encoding="euc-kr"?'.'>';
$tpl->setLayout('blank');
$tpl->define('TREE',WebApp::getTemplate('party/menu/admin/xml.tpl'));
$tpl->assign('ITEM',&$row);
$tpl->assign(array(
    'is_menu_add'   =>  (count($row) < 10 ? true : false)
));
$tpl->print_('TREE');
exit;


?>
