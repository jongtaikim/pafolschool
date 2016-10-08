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
	
	



if($passwd == "1118") {
	$_SESSION['PASSWD2'] = "true";
}

if(!$gu)  $gu = "a";


$DB = &WebApp::singleton('DB');
if(!$page = $_REQUEST['page']) $page = 1;
$listnum = 40;
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

$psql =" and num_oid > 0";


if($arba) {
	$psql2 = "and str_arba ='$arba'";
}


if($def_organ) {
	$psql3 = "and str_def_organ ='$def_organ'";
}


if($pro1) {
	$psql4 .= "and str_pro1 ='$pro1'";
}

if($pro2) {
	$psql4 .= "and str_pro2 ='$pro2'";
}

if($pro3) {
	$psql4 .= "and str_pro3 ='$pro3'";
}

if($pro4) {
	$psql4 .= "and str_pro4 ='$pro4'";
}

if($pro5) {
	$psql4 .= "and str_pro5 ='$pro5'";
}

if($pro6) {
	$psql4 .= "and str_pro6 ='$pro6'";
}

$sql = "SELECT COUNT(*) FROM TAB_ORGAN where  str_hometype = 'HOME'   $where $psql $psql2 $psql3 $psql4";
$total = $DB->sqlFetchOne($sql);
if(!$total) $total = 0;



$sql = "	
select a.* from (
         select ROWNUM as RNUM, b.* from (
             
 SELECT 
                *

                FROM TAB_ORGAN

				where 

				str_hometype = 'HOME'
				

                $where $psql $psql2 $psql3 $psql4
			    order by num_oid desc

)b)a
                where a.RNUM >= ".$offset." and a.RNUM <=($offset+$listnum)";


	$data = $DB->sqlFetchAll($sql);



for($ii=0; $ii<count($data); $ii++) {
	$sql = "select count(*) from TAB_BOARD a , TAB_MENU b where a.num_oid = ".$data[$ii][num_oid]."  
	and a.num_oid = b.num_oid and a.num_mcode = b.num_mcode and b.str_type = 'board#B' ";

	$data[$ii][bbs_count] = $DB -> sqlFetchOne($sql);

	if(is_dir(_DOC_ROOT."/module/bbsmove/".$data[$ii][num_oid])) $data[$ii][bbsmove_link] = "/bbsmove.".$data[$ii][num_oid].".board_curl1?ooid=".$data[$ii][num_oid];
}


$sql = "
select  str_def_organ, count(num_oid) as counet from  TAB_ORGAN  where str_hometype = 'HOME'  $psql  $psql4 group by str_def_organ
	";

$str_def_organ_arr = $DB -> sqlFetchAll($sql);

$tpl->assign(array('STR_DEF_R'=>$str_def_organ_arr));

 

$sql = "
select count(n.num_oid) as counter,n.str_arba from ( select a.num_oid from TAB_BOARD a , TAB_MENU b where a.num_oid = b.num_oid and a.num_mcode = b.num_mcode and b.str_type = 'board#B' ) g, TAB_ORGAN n where g.num_oid = n.num_oid group by  n.str_arba order by counter desc
	";

$bbs_count = $DB -> sqlFetchAll($sql);

$sql = "
select count(n.num_oid) from ( select a.num_oid from TAB_BOARD a , TAB_MENU b where a.num_oid = b.num_oid and a.num_mcode = b.num_mcode and b.str_type = 'board#B' ) g, TAB_ORGAN n where g.num_oid = n.num_oid ";

$bbs_count_total = $DB -> sqlFetchOne($sql);
//echo $sql;
$tpl->assign(array('BBS_COUNT'=>$bbs_count,'BBS_COUNT_TOTAL'=>$bbs_count_total));



$tpl->setLayout('admin');
$tpl->define("CONTENT", Display::getTemplate("manage/organ3.htm"));



$tpl->assign(array(
	'LIST'			=>	$data,
	'page'			=>	$page,
	'total'			=>	$total,
	'listnum'		=>	$listnum,
	'search_key'	=>	$search_key,
	'search_value'	=>	$search_value,
	'mcode'	=>	$mcode,
	'str_school'=>$str_school,
	'gu'=>$gu,
	'arba'=>$arba,
	'def_organ'=>$def_organ,
	'pro1'=>$pro1,
	'pro2'=>$pro2,
	'pro3'=>$pro3,
	'pro4'=>$pro4,
	'pro5'=>$pro5,
	'pro6'=>$pro6,

));


	 break;
	case "POST":

		 $sql = "UPDATE ".TAB_ORGAN." SET str_text2='$str_text2',str_arba_count='$str_arba_count' WHERE num_oid=$oid";
		 $DB->query($sql);
		 $DB->commit();

		WebApp::moveBack();

	 break;
	}
?>