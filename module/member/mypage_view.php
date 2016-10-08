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

$table = "TAB_ORDER";
$table2 = "TAB_CAMP";
$table3 = "TAB_LMS_CATE";

switch ($REQUEST_METHOD) {
	case "GET":
	
	
	$DOC_TITLE="str:마이페이지";
	
	if($ccode){
		$where .= " and num_ccode = '".$ccode."' ";
	}
	


	$sql = "
	select * from ".$table." where num_oid = '$_OID'  and str_order_code = '".$order_code."' ";
	$data = $DB->sqlFetch($sql);
	$r_data = $data;

	$sql = "select * from ".$table." where num_oid = '$_OID' and str_pr_name1 = '".$data[str_pr_name1]."' and  str_pr_name2 = '".$data[str_pr_name2]."' and str_addr1 = '".$data[str_addr1]."' and  str_st_name <> '".$data[str_st_name]."' ";
	$brs_data = $DB -> sqlFetchAll($sql);
	for($ii=0; $ii<count($brs_data); $ii++) {
		$sql = "select str_title from TAB_LMS_CATE where num_oid = '$_OID' and num_ccode = '".$brs_data[$ii][num_ccode]."'";
		$brs_data[$ii][ccode_title] = $DB -> sqlFetchOne($sql);
	}
	
	$tpl->assign(array('brs_LIST'=>$brs_data));

	$tel = explode("-",$data[str_phone]);
	$data[tel1] = $tel[0];
	$data[tel2] = $tel[1];
	$data[tel3] = $tel[2];

	$tel = explode("-",$data[str_handphone]);
	$data[tel11] = $tel[0];
	$data[tel22] = $tel[1];
	$data[tel33] = $tel[2];

	$email = explode("@",$data[str_email]);
	$data[email1] = $email[0];
	$data[email2] = $email[1];

	$email = explode("@",$data[str_email]);
	$data[email1] = $email[0];
	$data[email2] = $email[1];

	$jumin = explode("-",$data[str_jumin]);
	$data[jumin1] = $jumin[0];
	$data[jumin2] = $jumin[1];
	
	if($data[dt_bank_date]) $data[dt_bank_date] = date("Y-m-d",$data[dt_bank_date]); else $data[dt_bank_date]="";
	$tpl->assign($data);

	$sql = "
	select * from ".$table2." where num_oid = '$_OID'  and num_ccode = '".$data[num_ccode]."' and num_serial = '".$data[num_serial]."' ";
	$data = $DB->sqlFetch($sql);

	$num_ccode = $data[num_ccode];
	$tpl->assign($data);

	$sql = "
	select * from ".$table3." where num_oid = '$_OID'  and num_ccode = '".$data[num_ccode]."' ";
	$data = $DB->sqlFetch($sql);
	$tpl->assign($data);
	
	$sql = "select str_title as ccode_title   from TAB_LMS_CATE where num_oid = '$_OID' and num_ccode = '".$data[num_ccode]."'";
	$datas = $DB -> sqlFetch($sql);
	$tpl->assign($datas);
	


	$sql = "select str_title as ccode_title_p1   from TAB_LMS_CATE where num_oid = '$_OID' and num_ccode = '".$r_data[num_ccode_p1]."'";
	$datas = $DB -> sqlFetch($sql);
	$tpl->assign($datas);

	$sql = "select str_title as ccode_title_p2   from TAB_LMS_CATE where num_oid = '$_OID' and num_ccode = '".$r_data[num_ccode_p2]."'";
	$datas = $DB -> sqlFetch($sql);
	$tpl->assign($datas);
	
		
	

	$tpl->setLayout('@sub');
	$tpl->define("CONTENT", Display::getTemplate("member/mypage_view.htm"));
	



	 break;
	case "POST":

	
	 break;
	}

?>