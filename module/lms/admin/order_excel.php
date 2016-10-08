<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2012-06-17
* 작성자: 김종태
* 설   명: 엑셀다운로드
*****************************************************************
* 
*/
	$DB = &WebApp::singleton('DB');
	$table = "TAB_ORDER";

	$excelnm = "신청자목록 ".date("Ymd_H:i:s");
	header( "Content-type: application/vnd.ms-excel" ); 
	header( "Content-Disposition: attachment; filename=".$excelnm.".xls" ); 
	header( "Content-Description: PHP5 Generated Data" );
	

	$sql = "
	select * from ".$table." where num_oid = '$_OID'   $add_where $psqls order by dt_date desc ";

	//echo  $sql;

	$data = $DB->sqlFetchAll($sql);


	
	for($ii=0; $ii<count($data); $ii++) {
		$sql = "select str_title from TAB_LMS_CATE where num_oid = '$_OID' and num_ccode = '".$data[$ii][num_ccode]."' ";
		$data[$ii][str_ccode_text] = $DB -> sqlFetchOne($sql);
		
		$sql = "select * from TAB_CAMP where num_oid = '$_OID' and  num_ccode = '".$data[$ii][num_ccode]."' and num_serial = '".$data[$ii][num_serial]."'";
		$data[$ii][camp] = $DB -> sqlFetch($sql);
		
		
		$data[$ii][camp][start_date] = substr($data[$ii][camp][num_start_date],0,4)."년 ".substr($data[$ii][camp][num_start_date],4,2)."월 ".substr($data[$ii][camp][num_start_date],6,2)."일";
		$data[$ii][camp][end_date] =  substr($data[$ii][camp][num_end_date],0,4)."년 ".substr($data[$ii][camp][num_end_date],4,2)."월 ".substr($data[$ii][camp][num_end_date],6,2)."일";
		
		$sql = "select count(*) from $table where num_oid = '$_OID' and str_id = '".$data[$ii][str_id]."' and str_order_st = '1' ";
		$data[$ii][num_counter] = $DB -> sqlFetchOne($sql);


	}

	$tpl->assign(array('LIST'=>$data));
	
	$tpl->setLayout('none');
	$tpl->define('CONTENT', Display::getTemplate('lms/admin/order_excel.html'));


?>