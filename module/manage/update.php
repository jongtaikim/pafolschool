<?
/***********************************
*  새로운 회원관리 아작스 모듈
*  작성자 : 김종태
**********************************/



$DB = &WebApp::singleton("DB");
$table = "TAB_ORGAN_ORDER"; //사용할 테이블 명

switch ($mode) {
	
	
	
	case "update":


	foreach( $_REQUEST as $val => $value )
	{

	
	
		$update_val .= "$val = '".iconv("utf-8","euc-kr",$value)."',";
	
	
	} 

	$update_val = explode(",end",$update_val);
	$update_val = $update_val[0];
	




	$update_val = explode(",mode",$update_val);
	$update_data = $update_val[0];


	$update_where = str_replace(","," and ",$update_val[1]);

	$update_where = explode("'$mode'",$update_where);
	$update_where = $update_where[1];
	$update_where = " where  num_step > '0' ".$update_where ;
	




	$sql = 
			"update $table set   $update_data   $update_where
			";


//echo $sql;
//	exit;
		if($DB->query($sql)){
		$DB->commit();
			
echo "<FONT  COLOR=red>".date("Y-m-d H:i:s", $str_update_date);

		}else{
	echo "N";
		}


	break;
	


case "file_del":


	foreach( $_REQUEST as $val => $value )
	{

	
	
		$update_val .= "$val = '".iconv("utf-8","euc-kr",$value)."',";
	
	
	} 

	$update_val = explode(",end",$update_val);
	$update_val = $update_val[0];
	




	$update_val = explode(",mode",$update_val);
	$update_data = $update_val[0];


	$update_where = str_replace(","," and ",$update_val[1]);

	$update_where = explode("'$mode'",$update_where);
	$update_where = $update_where[1];
	$update_where = " where  num_oid = '1' ".$update_where ;
	




	$sql = 
			"delete from tab_files  $update_where
			";


//echo $sql;
//	exit;
		if($DB->query($sql)){
		$DB->commit();
			
echo "<FONT  COLOR=red>".date("Y-m-d H:i:s", mktime());

		}else{
	echo "N";
		}


	break;

	
}
?>