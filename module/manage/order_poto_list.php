<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-01-30
* 작성자: 김종태
* 설  명: 사이트 신청
*****************************************************************
* 
*/
$DB = &WebApp::singleton("DB");

$FH = &WebApp::singleton('FileHost','main','ogran_data');
$id = $_REQUEST['id'];
$flg = $_REQUEST['flg'];
$del=$_REQUEST['del'];

switch ($REQUEST_METHOD) {
	case "GET":
	

	



$DOC_TITLE = "str:포트폴리오 보기";	

if(!$listnum)$listnum = 30;

$total = $DB->sqlFetchOne("select count(*) from bs_organ_order");
if(!$total) $total = 0;
if(!$page) $page = 1;
$seek = $listnum * ($page - 1);
$offset = $seek + $listnum;


$key = $_REQUEST['key'];
$search = $_REQUEST['search'];
if ($key && $search) $whereadd = "and $key LIKE '%$search%'";

if($num_step) {

	$whereadd2 = " and num_step = '$num_step' ";

}




$sql = "select a.* from (
         select ROWNUM as RNUM, b.* from (
              select 

   num_step, str_end_date, TO_CHAR(dt_date,'YYYY-MM-DD') dt_date, 
   str_home_type, str_design, str_opt1, 
   str_opt2, str_opt3, str_name, 
   str_organ, str_zip, str_addr1, 
   str_addr2, str_tel, str_handtel, 
   str_email, str_memo,str_st,str_pot
 
 from tab_organ_order where 
 str_pot > 0 and str_home_type = '$code' $whereadd 

 order by num_step desc 
 
 )b)a
                where a.RNUM >= $seek and a.RNUM <= $offset ";


$row = $DB -> sqlFetchAll($sql);




for($ii=0; $ii<count($row); $ii++) {

	

$num_s = $row[$ii][num_step];

$tpl->assign(array('num_step'=> $num_s));

if($row[$ii][str_home_type] != "B-MART") {
$sql = "select str_host from tab_organ where str_num_step = '$num_s' order by num_oid desc ";
$row[$ii][ORGAN_i] = $DB -> sqlFetchOne($sql);

}else{

$sql = "select str_dir from bookmart.tab_organ where str_num_step = '$num_s' order by num_oid desc ";
$row[$ii][ORGAN_i] = $DB -> sqlFetchOne($sql);

}

}

$tpl->assign(array('LIST_organ'=>$row));


$tpl->assign(array(


	'mcode'=>$mcode,
	'listnum'=>$listnum,
	'total'=>$total,
	'page'=>$page,
    'key'=>$key,
    'search'=>$search,
    'code'=>$code,

));


	$tpl->setLayout('@sub');
	$tpl->define("CONTENT", "module/manage/order_poto_list.htm");

	




	 break;
	
	case "POST":


	 break;

	}


?>