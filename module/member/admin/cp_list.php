<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-01-30
* 작성자: 김종태
* 설  명: 쿠폰 리스트
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');

$search_key = $_REQUEST['search_key'];
$search_value = $_REQUEST['search_value'];
if(isset($search_key) && isset($search_value)) {
	$where = "WHERE $search_key = '".$search_value."' ";
}

if(!$page = $_REQUEST['page']) $page = 1; //페이지번호
if(!$listnum)$listnum = 15;  //한페이지에 보일 수

$sql = "SELECT count(*) FROM TAB_BOOKCOUPON ".$where;
$total = $DB->sqlFetchOne($sql);
if(!$total) $total = 0; // 전체 글수


$seek = $listnum * ($page - 1);
$offset = $seek + $listnum;
$fno = $total-($listnum * ($page-1));

$sql = "
select a.* from (
         select ROWNUM as RNUM, b.* from (


select str_coupon, str_use, str_id, str_date from TAB_BOOKCOUPON
$where

)b)a
                where a.RNUM >  $seek and a.RNUM <= $offset ";

$data = $DB->sqlFetchAll($sql);

$tpl->setLayout('no2');
$tpl->assign(array(
'listnum'=>$listnum,
'LIST'=>$data,
'page'=>$page,
'total'=>$total,
'fno'=>$fno,
'search_key'=>$search_key,
'search_value'=>$search_value
));
$tpl->define("CONTENT", Display::getTemplate("member/admin/cp_list.htm"));
	

?>