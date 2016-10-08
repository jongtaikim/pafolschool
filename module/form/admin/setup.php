<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-01-30
* 작성자: 김종태
* 설  명: 몰라임마~!
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');


switch ($REQUEST_METHOD) {
	case "GET":

$sql = "select * from TAB_FORM_CSS where num_oid = '$_OID' and num_mcode = '".$code."'  ";
$data = $DB -> sqlFetch($sql);
if($data[dt_date]) $data[dt_date] = date("Y-m-d",$data[dt_date]); else $data[dt_date] = date("Y-m-d");
if($data[end_date]) $data[end_date] = date("Y-m-d",$data[end_date]); else $data[end_date] = date("Y")."-12-31";
$tpl->assign($data);



$sql = "select 

 
 str_col_name, 
   str_col_type, str_col_width, str_col_admin, 
   str_value1, str_value2, str_value3, 
   str_value4, str_value5, str_not_null

 from TAB_FORM_CONFIG where num_oid = '$_OID' and num_mcode = '$code' order by num_serial asc ";


$data = $DB -> sqlFetchAll($sql);
$tpl->assign(array('LIST'=>$data));
$tpl->assign(array('code'=>$code));







	$tpl->define("CONTENT", Display::getTemplate("form/admin/setup.htm"));

	$tpl->assign(array('mode'=>$mode));
	
	
	 break;
	case "POST":
	
	


if($mode !="edit"){


$end_date = WebApp::mkday($end_date);
$dt_date = WebApp::mkday($dt_date);

$sql = "UPDATE ".TAB_FORM_CSS." SET str_title='$str_title',str_login='$str_login' ,end_date = '$end_date' ,dt_date = '$dt_date' WHERE num_oid=$_OID and num_mcode = '$code'";
$DB->query($sql);



$sql = "select count(num_mcode) from TAB_FORM_CSS where num_oid = $_OID and num_mcode = '".$code."' ";
$incount = $DB -> sqlFetchOne($sql);
if(!$incount){

$sql = "select max(num_mcode)+1 from TAB_FORM_CSS where num_oid = $_OID ";
$max_code = $DB -> sqlFetchOne($sql);
if(!$max_code) $max_code = 1;

$sql = "INSERT INTO ".TAB_FORM_CSS." (
			num_oid , num_mcode, str_title,str_login ,end_date,dt_date
			) VALUES (
			"._OID." , ".$max_code.", '$str_title','$str_login' ,'$end_date','$dt_date'
			) ";

			$DB->query($sql);
			$DB->commit();



$code = $max_code;
}			

$sql = "delete from TAB_FORM_CONFIG where num_oid = '$_OID' and num_mcode = '".$code."' ";
$DB->query($sql);
$DB->commit();



for($ii=0; $ii<count($str_col_name); $ii++) {
if($str_col_name[$ii] !="") {
	

$sql = "select max(num_serial)+1 from TAB_FORM_CONFIG where num_oid = '$_OID' and num_mcode = '".$code."' ";
$max_num = $DB -> sqlFetchOne($sql);
if(!$max_num) $max_num= 1;


$sql = "INSERT INTO ".TAB_FORM_CONFIG." 
	( 
   num_oid,
   num_mcode,
   num_serial,
   str_col_name, 
   str_col_type, 
   str_col_width, 
   str_col_admin, 
   str_value1, 
   str_value2, 
   str_value3, 
   str_value4, 
   str_value5, 
   str_not_null
	
	) 
	VALUES 
	($_OID,
	'$code',
    '$max_num',
   '".$str_col_name[$ii]."', 
   '".$str_col_type[$ii]."', 
   '".$str_col_width[$ii]."', 
   '".$str_col_admin[$ii]."', 
   '".$str_value1[$ii]."', 
   '".$str_value2[$ii]."', 
   '".$str_value3[$ii]."', 
   '".$str_value4[$ii]."', 
   '".$str_value5[$ii]."', 
   '".$str_not_null[$ii]."'

	) ";
	
	$DB->query($sql);
	$DB->commit();



}	
}

}else{

 $sql = "UPDATE ".TAB_FORM_CSS." SET str_top ='$str_top' , str_foot = '$str_foot' WHERE num_oid=$_OID and num_mcode = '$code'";
// echo $sql;

$DB->query($sql);
}

 
echo '<script>alert("저장되었습니다.");</script>';
echo "<meta http-equiv='Refresh' Content=\"0; URL='/form.admin.setup?admin=y&code=$code'\">";



	break;
	}

?>