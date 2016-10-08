<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/party/list.php
* 작성일: 2006-05-17
* 작성자: 이범민
* 설  명: 동아리 목록
*****************************************************************
* 
*/
//2008-05-07 메뉴에 등록된 부분이 있을경우 해당 매뉴페이지로 이동 종태
if(!$mcode) {
	$DB = &WebApp::singleton("DB");
	$sql = "select num_mcode from TAB_MENU where num_oid = '$_OID' and str_type = 'link#party' ";
	$mcode_meta = $DB -> sqlFetchOne($sql);	
	if($mcode_meta) {
		if(strstr($REQUEST_URI,"?")){
			echo "<meta http-equiv='Refresh' Content=\"0; URL='".$REQUEST_URI."&mcode=$mcode_meta'\">";
		}else{
			echo "<meta http-equiv='Refresh' Content=\"0; URL='".$REQUEST_URI."?mcode=$mcode_meta'\">";
		}
		exit;
	}
}

$DOC_TITLE = 'str:동아리카페 목록';

$DB = &WebApp::singleton('DB');

if(!$page = $_REQUEST['page']) $page = 1; //페이지번호
if(!$listnum)$listnum = 15;  //한페이지에 보일 수

if($searchvalue) $where = " and $searchkey like '%$searchvalue%'";

if($ccode) {
	if(strlen($ccode) ==2) {
	$where .= " and num_ccode like '".$ccode."%'";	
	}else{
	$where .= " and num_ccode = '".$ccode."'";
	}
	

}

 $where .= " and str_type = 'cafe'";

$sql = "SELECT COUNT(*) FROM TAB_PARTY WHERE NUM_OID=$_OID $where";
$total = $DB->sqlFetchOne($sql);
if(!$total) $total = 0; // 전체 글수
$seek = $listnum * ($page - 1);
$offset = $seek + $listnum;
$fno = $total-($listnum * ($page-1));

$sql = "
select a.* from (
select ROWNUM as RNUM, b.* from (
	select * from TAB_PARTY where num_oid=$_OID $where
)b)a
where a.RNUM >  $seek and a.RNUM <= $offset ";

$data = $DB -> sqlFetchAll($sql);



$tpl->assign(array(
'listnum'=>$listnum,
'page'=>$page,
'total'=>$total,
'fno'=>$fno,
'searchkey'=>$searchkey,
'searchvalue'=>$searchvalue,
'ccode'=>$ccode
));

$tpl->assign('CafeLIST',$data);

$tpl->setLayout();
$tpl->define('CONTENT','html/party/list.htm');
$tpl->assign('LIST',$data);

function cut_str($str,$len,$tail="...") {
	if(strlen($str) > $len) {
		for($i=0; $i<$len; $i++) if(ord($str[$i])>127) $i++;
		$str=substr($str,0,$i).$tail;
	}
	return $str;
}
?>