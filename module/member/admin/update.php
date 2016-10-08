<?
/***********************************
*  새로운 회원관리 아작스 모듈
*  작성자 : 김종태
**********************************/



$DB = &WebApp::singleton("DB");
$table = "TAB_MEMBER"; //사용할 테이블 명

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
	$update_where = " where  num_oid = '$_OID' ".$update_where ;
	




	$sql = 
			"update $table set   $update_data   $update_where
			";


//	exit;
		$DB->query($sql);
		if($DB->commit()){
			
	echo "Y";

		}


	break;
	

	
}
?>