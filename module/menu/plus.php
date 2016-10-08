<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2009-01-15
* 작성자: 
* 설   명: 
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');

switch ($mode) {
	case "plus":
	
include 'admin_menu.php';



$pn_1 = substr($pn,1,1)-1;
$pn_2 = substr($pn,3,1)-1;

if($pn_2 > 0) {
$str_title = $menu[$pn_1][submenu][$pn_2][title];
$url = $menu[$pn_1][submenu][$pn_2][link].$menu[$pn_1][submenu][$pn_2][pn];
}else{
$str_title = $menu[$pn_1][title];
$url = $menu[$pn_1][link].$menu[$pn_1][pn];
}

$url = $act3;
if(!$str_title) $str_title = "(알수없음)";

if($title_q) $str_title = $title_q;

$sql = "select max(num_serial)+1 from TAB_MENU_INDEX where num_oid = $_OID ";

$max_num = $DB -> sqlFetchOne($sql);
if(!$max_num)  $max_num = 1;



$sql = "INSERT INTO ".TAB_MENU_INDEX." (	
		  num_oid,
		  num_serial,
		  str_url,
		  str_title

		   ) VALUES (
		 
		 $_OID,
		 $max_num,
		'$url',
		'$str_title'
		 ) ";

		$DB->query($sql);
		$DB->commit();


WebApp::moveBack();

	
	 break;
	case "del":

 $sql = "delete from TAB_MENU_INDEX where num_oid = "._OID." and num_serial = ".$serial."";

 $DB->query($sql);
 $DB->commit();

WebApp::moveBack();
	break;
	}

?>