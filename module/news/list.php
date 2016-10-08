<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* : list.php
* 작성일: 2009-07-09
* 작성자: 김종태
* 설  명: 고정게시판 목록/보기
*****************************************************************
* 
*/
// 서브 메뉴 부분 



$DB = &WebApp::singleton('DB');

$code = $_REQUEST['code'];
if(!$page = $_REQUEST['page']) $page = 1;

if(!$listnum)$listnum = 10;

$key = $_REQUEST['key'];
$search = $_REQUEST['search'];
if ($key && $search) $whereadd = "AND $key LIKE '%$search%'";

$sql = "SELECT COUNT(*) FROM ".TAB_MAIN_BOARD." WHERE NUM_OID=$_OID and str_code='$code' $whereadd";


$total = $DB->sqlFetchOne($sql);
if(!$total) $total = 0;


$page = $_REQUEST['page'];
if (!$page) $page = 1;

$seek = $listnum * ($page - 1);
$offset = $seek + $listnum;

$sql = "
SELECT 

	NUM_SERIAL,
	STR_TITLE,
	NUM_HIT,
	 DT_DATE,
	STR_THUMB,
	STR_MAIN_VIEW,
	NUM_ORDER
	
		
		FROM ".TAB_MAIN_BOARD."
		WHERE

	NUM_OID=$_OID AND
	STR_CODE='$code'
	
	$whereadd

	order by num_serial desc limit $seek,$listnum

";

//echo  $sql;


if($data = $DB->sqlFetchAll($sql)) array_walk($data,'list_format');


$tpl->define("CONTENT",WebApp::getTemplate("news/skin/$skin/list.htm"));
$tpl->assign("LIST",$data);

//글쓰기 권한
if($MEM_TYPE[0] == "t" || $_SESSION['ADMIN']){
 $tpl->assign(array('writable'=>"Y"));
}



$tpl->assign(array(
	'LIST'=>$data,
	'listnum'=>$listnum,
	'env'=>$env,
	'mcode'=>$mcode,
	'total'=>$total,
	'page'=>$page,
    'key'=>$key,
    'search'=>$search,
	'id'=>$id
));





function list_format(&$arr) {
	global $URL,$total,$page,$listnum;
	static $num;
	$arr['num'] = $total - (($page-1) * $listnum) - $num++;
	$arr['readlink'] = $URL->setVar(array('id'=>$arr['num_serial']));
	$arr['dt_date'] = date("Y.m.d",$arr[dt_date]);

}


?>
