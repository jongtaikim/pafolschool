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
switch ($REQUEST_METHOD) {
	case "GET":
	
	



if($passwd == "1118b") {
	$_SESSION['PASSWD2'] = "true";
}

 $gu = "b";


$DB = &WebApp::singleton('DB');
if(!$page = $_REQUEST['page']) $page = 1;
$listnum = 30;
$offset = ($page-1) * $listnum;

$search_key = $_REQUEST['search_key'];
$search_value = $_REQUEST['search_value'];
$str_school = $_REQUEST['str_school'];

if($search_key && $search_value) {

	if($search_key == 'str_organ') {
		$where = "  and str_organ LIKE '%$search_value%'";
	} elseif($search_key == 'str_domain') {
		$where = "  and str_domain LIKE '%$search_value%' OR str_host LIKE '%$search_value%'";
	} elseif($search_key == 'num_oid') {
        $where = "  and num_oid = $search_value";
    }
} 
if($str_school) $where .= " and str_school='".$str_school."'";

if(!$code) {
	$code = "SCHOOL";

}


	$psql = "and num_oid >= 20289 and num_oid < 20320";


$sql = "SELECT COUNT(*) FROM TAB_ORGAN where  str_hometype = 'HOME'   $where $psql";
$total = $DB->sqlFetchOne($sql);
if(!$total) $total = 0;

$sql = "	
select a.* from (
         select ROWNUM as RNUM, b.* from (
             
 SELECT 
                *

                FROM ".TAB_ORGAN." 

				where 

				str_hometype = 'HOME'
				

                $where $psql
			    order by num_oid desc

)b)a
                where a.RNUM >= ".$offset." and a.RNUM <=($offset+$listnum)";

	//echo $sql;
	$data = $DB->sqlFetchAll($sql);



for($ii=0; $ii<count($data); $ii++) {
	$sql = "select count(*) from TAB_BOARD where num_oid = ".$data[$ii][num_oid]." ";
	$data[$ii][bbs_count] = $DB -> sqlFetchOne($sql);
}


$tpl->setLayout('admin');
$tpl->define("CONTENT", "/html/manage/organ3.htm");




$tpl->assign(array(
	'LIST'			=>	$data,
	'page'			=>	$page,
	'total'			=>	$total,
	'listnum'		=>	$listnum,
	'search_key'	=>	$search_key,
	'search_value'	=>	$search_value,
	'mcode'	=>	$mcode,
	'str_school'=>$str_school,
	'gu'=>$gu
));


	 break;
	case "POST":



		 $sql = "UPDATE ".TAB_ORGAN." SET str_memo='$str_memo',str_gi_id='$str_gi_id',str_gi_pw='$str_gi_pw',str_arba='$str_arba' WHERE num_oid=$oid";

		 $DB->query($sql);
		 $DB->commit();
	

	WebApp::moveBack();

	 break;
	}

?>