<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2011-08-19
* 작성자: 김종태
* 설   명: 교육신청 첫페이지
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');


switch ($REQUEST_METHOD) {
	case "GET":
	

	if(!$types) $types = 1;
	if(!$ccode1) $ccode1 = 1010;
	

	$tpl->assign(array(
		'types'=>$types,
		'ccode1'=>$ccode1,
		
	 ));

	

	$sql = "select * from TAB_LMS_CATE where num_oid = '$_OID' and LENGTH(NUM_CCODE)=4 order by num_step asc";
	$row = $DB -> sqlFetchAll($sql);
	$tpl->assign(array('cate1_LIST'=>$row));

	$sql = "select * from TAB_LMS where num_oid = '$_OID' and str_type = '$types' and str_title='".$ccode1."' ";
	
	$row = $DB -> sqlFetchAll($sql);
	$tpl->assign(array('cate2_LIST'=>$row));
	
	

	$tpl->setLayout('@sub');
	$tpl->define("CONTENT", Display::getTemplate("lms/cert.htm"));
	
	 break;
	case "POST":

	$_SESSION[NAMES] = $_POST[str_name];
	$_SESSION[PHONES] = $_POST[str_phone];
	$_SESSION[EMAILS] = $_POST[str_email];

	$sql = "select * from TAB_LMS_HUMAN where num_oid = '$_OID'  and str_name = '".$_POST[str_name]."' and str_phone = '".$_POST[str_phone]."' and str_email = '".$_POST[str_email]."' ";
	$human = $DB -> sqlFetchAll($sql);

	
	for($ii=0; $ii<count($human); $ii++) {
		
		$sql = "select * from TAB_LMS_ORDER where num_oid = '$_OID' and str_order_code = '".$human[$ii][str_order_code]."'" ;
		$human[$ii][data] = $DB -> sqlFetch($sql);

		$sql = "select * from TAB_LMS where num_oid = '$_OID' and num_serial = '".$human[$ii][data][num_lms_code]."'" ;
		$human[$ii][lms] = $DB -> sqlFetch($sql);

	}
	

	$tpl->assign(array('LIST'=>$human));
	
	
	
	$tpl->assign($human);
	$tpl->assign($orders);
	
	
		
	$tpl->setLayout('@sub');
	$tpl->define("CONTENT", Display::getTemplate("lms/cert_ok.htm"));
	
	

	 break;
	}

?>