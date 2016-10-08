<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-09-29
* 작성자: 김종태
* 설  명:  사이트 입력폼 작성
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');




switch ($REQUEST_METHOD) {
	case "GET":


$sql = "select count(*) from TAB_FORM where num_oid = $_OID and str_id = '".$_SESSION[USERID]."' and num_mcode = ".$code."";
$idchk = $DB -> sqlFetchOne($sql);
if($idchk > 0 && $mode && !$re) {

}


$sql = "select * from TAB_FORM_CSS where num_oid = '$_OID' and num_mcode = '".$code."'  ";
$data = $DB -> sqlFetch($sql);
if($data[dt_date]) $data[dt_date] = date("Y-m-d",$data[dt_date]); else $data[dt_date] = date("Y-m-d");
if($data[end_date]) $data[end_date] = date("Y-m-d",$data[end_date]); else $data[end_date] = date("Y")."-12-31";
$tpl->assign($data);



$sql = "select 
count(*)
 from TAB_FORM_CONFIG where num_oid = '$_OID' and num_mcode = '$code' ";

$total = $DB -> sqlFetchOne($sql);


$sql = "select 

 *

 from TAB_FORM_CONFIG where num_oid = '$_OID' and num_mcode = '$code'
 order by num_serial asc
 ";

$data = $DB -> sqlFetchAll($sql);

$tpl->assign(array('LIST'=>$data,'total'=>$total));
$tpl->assign(array('code'=>$code));





// $asql = "and str_id = '".$_SESSION[USERID]."' " ;



if(!$page = $_REQUEST['page']) $page = 1;

if(!$listnum)$listnum = 10;
$sql = "SELECT COUNT(*) FROM TAB_FORM where num_oid = '$_OID' and num_mcode = $code $asql ";


$total = $DB->sqlFetchOne($sql);
if(!$total) $total = 0;


$page = $_REQUEST['page'];
if (!$page) $page = 1;

$seek = $listnum * ($page - 1);
$offset = $seek + $listnum;

$sql = "


select * from TAB_FORM where num_oid = '$_OID' and num_mcode = $code $asql 
order by num_serial desc LIMIT $seek , $listnum
";

//echo  $sql;


if($data = $DB->sqlFetchAll($sql)) array_walk($data,'list_format');


$sql = "select 

 
 str_col_name, 
   str_col_type, str_col_width, str_col_admin, 
   str_value1, str_value2, str_value3, 
   str_value4, str_value5, str_not_null

 from TAB_FORM_CONFIG where num_oid = '$_OID' and num_mcode = '$code' ";

$form_data = $DB -> sqlFetchAll($sql);



$sql = "select 
count(*)
 from TAB_FORM_CONFIG where num_oid = '$_OID' and num_mcode = '$code' ";

$form_total = $DB -> sqlFetchOne($sql);

$tpl->assign(array(
'title'=>$title,
'LIST_data'=>$data,
'form_data'=>$form_data,
'form_total'=>$form_total,
'page'=>$page,
'total'=>$total,
'listnum'=>$listnum,

'itemPerPage'=>$itemPerPage,
 'mode'=>$mode
));











	$tpl->setLayout();
	$tpl->define("CONTENT", Display::getTemplate("form/skin/$skin/write.htm"));
	
	
	

	 break;
	case "POST":

$sql = "select max(num_serial)+1 from TAB_FORM where num_oid = '$_OID' and num_mcode = '$code' ";

$max = $DB -> sqlFetchOne($sql);
if(!$max) $max =1;

$dt_date = mktime();

$sql = "INSERT INTO ".TAB_FORM." (	

   NUM_OID, 
   num_mcode, 
   NUM_SERIAL, 
   STR_ID, 
   STR_VALUE1, 
   STR_VALUE2, 
   STR_VALUE3, 
   STR_VALUE4, 
   STR_VALUE5, 
   STR_VALUE6, 
   STR_VALUE7, 
   STR_VALUE8, 
   STR_VALUE9, 
   STR_VALUE10, 
   STR_VALUE11, 
   STR_VALUE12, 
   STR_VALUE13, 
   STR_VALUE14, 
   STR_VALUE15,
   DT_DATE
) VALUES (
					
   '$_OID', 
   '$code', 
   '$max', 
   '".$_SESSION[USERID]."', 
   '$str_value1', 
   '$str_value2', 
   '$str_value3', 
   '$str_value4', 
   '$str_value5', 
   '$str_value6', 
   '$str_value7', 
   '$str_value8', 
   '$str_value9', 
   '$str_value10', 
   '$str_value11', 
   '$str_value12', 
   '$str_value13', 
   '$str_value14', 
   '$str_value15',
   '$dt_date'

) ";

			$DB->query($sql);
			$DB->commit();
			
WebApp::moveBack('정상적으로 전송되었습니다.');




	 break;
	}

?>