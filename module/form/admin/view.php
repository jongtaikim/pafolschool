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
	

$sql = "select 
count(*)
 from TAB_FORM_CONFIG where num_oid = '$_OID' and num_mcode = '$code' ";

$total = $DB -> sqlFetchOne($sql);


$sql = "select 

 
 str_col_name, 
	 str_col_type, str_col_width, str_col_admin, 
	 str_value1, str_value2, str_value3, 
	 str_value4, str_value5, str_not_null

 from TAB_FORM_CONFIG where num_oid = '$_OID' and num_mcode = '$code' ";

$data = $DB -> sqlFetchAll($sql);

for($ii=0; $ii<count($data); $ii++) {
	$a = $ii +1;
	$sql = "
	
	select  STR_VALUE".$a."
	 
	 from TAB_FORM where num_oid = '$_OID' and num_mcode = '$code' and num_serial = '$num_serial' ";
	
	$data[$ii][value] = $DB -> sqlFetchOne($sql);
}

$sql = "select dt_date from TAB_FORM where num_oid = '$_OID' and num_mcode = '$code' and num_serial = '$num_serial' ";

$reg_date = date("Y-m-d",$DB -> sqlFetchOne($sql));

$tpl->assign(array('LIST'=>$data,'reg_date'=>$reg_date,'total'=>$total,'num_serial' =>$num_serial));
$tpl->assign(array('code'=>$code));








	$tpl->define("CONTENT", Display::getTemplate("form/admin/view.htm"));
	
	
	

	 break;
	case "POST":

$sql = "select max(num_serial)+1 from TAB_FORM where num_oid = '$_OID' and num_mcode = '$code' ";

$max = $DB -> sqlFetchOne($sql);
if(!$max) $max =1;

 $sql = "UPDATE ".TAB_FORM." SET 

	 str_value1 =      '$str_value1',  
	 str_value2 = 	  '$str_value2', 
	 str_value3 = 	  '$str_value3', 
	 str_value4 = 	  '$str_value4', 
	 str_value5 = 	  '$str_value5', 
	 str_value6 = 	  '$str_value6', 
	 str_value7 = 	  '$str_value7', 
	 str_value8 = 	  '$str_value8', 
	 str_value9 = 	  '$str_value9', 
	 str_value10 = 	 '$str_value10',
	 str_value11 = 	 '$str_value11',
	 str_value12 = 	 '$str_value12',
	 str_value13 = 	 '$str_value13',
	 str_value14 = 	 '$str_value14',
	 str_value15 =	 '$str_value15'
 
 WHERE num_oid=$_OID and num_serial = '$num_serial'";
 $DB->query($sql);
 $DB->commit();




WebApp::moveBack('저장되었습니다.');


	 break;
	}

?>