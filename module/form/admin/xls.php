<?
header("Content-type: application/vnd.ms-excel"); 
header("Content-Disposition: attachment; filename=".date("Y-m-d",mktime()).$mtitle.".xls"); 
header("Content-Description: PHP4 Generated Data"); 

/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-09-30
* 작성자: 김종태
* 설  명:  입력폼에 받은 데이터 확인
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');


switch ($REQUEST_METHOD) {
	case "GET":
	

$sql = "


select * from TAB_FORM where num_oid = '$_OID' and num_mcode = $code
order by num_serial desc

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
'LIST'=>$data,
'form_data'=>$form_data,
'form_total'=>$form_total,
'page'=>$page,
'total'=>$total,
'listnum'=>$listnum,

'itemPerPage'=>$itemPerPage
));




	$tpl->define("CONTENT", Display::getTemplate("form/admin/xls.htm"));
	
	 break;
	case "POST":
	 break;
	}

?>