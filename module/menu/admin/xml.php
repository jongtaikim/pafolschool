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




if ($cate) {
	$sql = "SELECT * FROM ".TAB_MENU." WHERE num_oid=$_OID AND num_cate LIKE '".$cate."__' ORDER BY num_step";
} else {
	$sql = "SELECT * FROM ".TAB_MENU." WHERE num_oid=$_OID AND LENGTH(num_cate)=2 ORDER BY num_step";
}


$data = $DB->sqlFetchAll($sql,OCI_ASSOC);

@array_walk($data,'cb_format_data');

$len = strlen($cate);

$maxmenu = 90;

if($maxmenu > count($data) &&  strlen($cate) < 8) {
$enable_add = "y";	
}


/*if($enable_add && $len > 1) {
//    // 빈메뉴만 하위메뉴 구성 가능
    $sql = "SELECT str_type FROM ".TAB_MENU." WHERE num_oid=$_OID AND num_cate=$cate";
    $enable_add = ($DB->sqlFetchOne($sql) == 'menu');
	if(strlen($cate) %3 == 0) {
		unset($enable_add);
	}
}
*/

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
    'parent'     => $cate,
    'enable_add' => $enable_add
));
$tpl->print_('TREE');
exit;

// {{{  Functions
function cb_format_data(&$arr) {
	$DB = &WebApp::singleton('DB');
	$_OID = $arr['num_oid'];
	$sql = "SELECT COUNT(*) FROM ".TAB_MENU." WHERE num_oid=$_OID AND num_cate LIKE '".$arr['num_cate']."__'";
    if(strlen($arr['num_cate']) < 8) $arr['submenu'] = 'src="menu.admin.xml?cate='.$arr['num_cate'].'"';
	if ($DB->sqlFetchOne($sql) > 0) $arr['submenu'] = 'src="menu.admin.xml?cate='.$arr['num_cate'].'"';
	//else $arr['submenu'] = '';
    //if (empty($arr['submenu'])) {
        switch ($arr['str_type']) {
            case 'menu':
                $arr['icon'] = 'image/icon/folder.png';
                break;
            case 'board#B':
                $arr['icon'] = 'image/icon/discuss.gif';
                break;
				  case 'board#G':
                $arr['icon'] = 'image/icon/jpg.gif';
                break;

				case 'tong_board#B':
                $arr['icon'] = 'image/icon/information.gif';
                break;


            case 'news':
                $arr['icon'] = '/html/board/skin/B1_board/image/notice_icon.gif';
                break;

			 case 'lms#C':
                $arr['icon'] = 'image/icon/wmv.gif';
                break;

			 case 'lms#A':
                $arr['icon'] = 'image/icon/wmv.gif';
                break;

				case 'lms#O':
                $arr['icon'] = 'image/icon/wmv.gif';
                break;


			 case 'board#C':
                $arr['icon'] = 'image/icon/avi.gif';
                break;
            case 'council':
                $arr['icon'] = 'image/icon/eml.gif';
                break;
            case 'link':
                $arr['icon'] = 'image/icon/url.gif';
                break;
            case 'doc_board':
                $arr['icon'] = 'image/icon/html.png';
                break;

			  case 'doc':
                $arr['icon'] = 'image/icon/html.png';
                break;
			 case 'qna_board':
                $arr['icon'] = 'image/icon/chm.gif';
                break;

				case 'member#L':
                $arr['icon'] = 'image/icon/member.gif';
                break;

				case 'member#J':
                $arr['icon'] = 'image/icon/member.gif';
                break;

				case 'member#M':
                $arr['icon'] = 'image/icon/member.gif';
                break;

				case 'member#D':
                $arr['icon'] = 'image/icon/member.gif';
                break;

				case 'member#F':
                $arr['icon'] = 'image/icon/member.gif';
                break;

				case 'mov_board':
                $arr['icon'] = 'image/icon/avi.gif';
                break;


				case 'form':
                $arr['icon'] = 'image/icon/cgi.gif';
                break;

				case 'ifr':
                $arr['icon'] = 'image/icon/ifr.gif';
                break;

				case 'poll':
                $arr['icon'] = 'image/icon/chm.gif';
                break;


				case 'lms#M':
                $arr['icon'] = 'image/icon/spl.gif';
                break;

				case 'lms#Z':
                $arr['icon'] = 'image/icon/cgi.gif';
                break;

				case 'lms#B':
                $arr['icon'] = 'image/icon/spl.gif';
                break;

				case 'lms#T':
                $arr['icon'] = 'image/icon/spl.gif';
                break;

				case 'lms#U':
                $arr['icon'] = 'image/icon/spl.gif';
                break;

				case 'lms#J':
                $arr['icon'] = 'image/icon/member.gif';
                break;

				case 'sitemap':
                $arr['icon'] = 'image/icon/cdup.gif';
                break;


				case 'starcash#L':
                $arr['icon'] = 'image/icon/asp.gif';
                break;


				case 'starcash#J':
                $arr['icon'] = 'image/icon/asp.gif';
                break;

				case 'starcash#M':
                $arr['icon'] = 'image/icon/asp.gif';
                break;



				case 'member#A':
                $arr['icon'] = 'image/icon/member.gif';
                break;

				case 'member#B':
                $arr['icon'] = 'image/icon/member.gif';
                break;

				default :
                $arr['icon'] = '/image/icon/com.gif';
                break;
        }
    //}



	$arr['str_title'] = htmlspecialchars($arr['str_title']);
}
// }}}


?>
