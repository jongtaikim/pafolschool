<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/manage/organ.php
* 작성일: 2008-11-26
* 작성자: 김종태
* 설  명:  학교정보검색
*****************************************************************
* 
*/
require_once "class.DB.php";
if(!$dbtype)  $dbtype = "ezschool";
$DB = new DB($dbtype); 

if(!$page = $_REQUEST['page']) $page = 1;
$listnum = 30;
$offset = ($page-1) * $listnum;

$search_key = $_REQUEST['search_key'];
$search_value = $_REQUEST['search_value'];

if($search_key && $search_value) {

	if($search_key == 'str_organ') {
		$where = "  and str_organ LIKE '%$search_value%'";
	} elseif($search_key == 'str_domain') {
		$where = "  and str_domain LIKE '%$search_value%' OR str_host LIKE '%$search_value%'";
	} elseif($search_key == 'num_oid') {
        $where = "  and num_oid = $search_value";
    }
} 

if(!$code) {
	$code = "SCHOOL";

}

$sql = "SELECT COUNT(*) FROM TAB_ORGAN where   num_oid > 0   $where";
$total = $DB->sqlFetchOne($sql);
if(!$total) {
    $total = 0;
} 


$sql = "	
select a.* from (
         select ROWNUM as RNUM, b.* from (
             
 SELECT 
                  
           *
                FROM ".TAB_ORGAN."
				where 
				 num_oid > 0
                $where
			    order by num_oid desc

)b)a
                where a.RNUM >= ".$offset." and a.RNUM <=($offset+$listnum)";

	
	$data = $DB->sqlFetchAll($sql);




$tpl->setLayout('admin');

$tpl->define("CONTENT", Display::getTemplate("manage/organ_ezschool.htm"));


$tpl->assign(array(
	'LIST'			=>	$data,
	'page'			=>	$page,
	'total'			=>	$total,
	'listnum'		=>	$listnum,
	'search_key'	=>	$search_key,
	'search_value'	=>	$search_value,
	'code'	=>	$code
));
?>