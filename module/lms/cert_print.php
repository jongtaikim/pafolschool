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

	$sql = "select * from TAB_LMS_HUMAN where num_oid = '$_OID'  and str_order_code = '".$order_code."' and num_lms_code = '".$lms_code."' and num_serial = '".$serial."'  ";
	$human = $DB -> sqlFetch($sql);
	
	$sql = "select * from TAB_LMS where num_oid = '$_OID' and num_serial = '".$lms_code."'" ;
	$human[lms] = $DB -> sqlFetch($sql);
	
	$sql = "select * from TAB_LMS_ORDER where num_oid = '$_OID' and str_order_code = '".$order_code."'" ;
	$human[data] = $DB -> sqlFetch($sql);
	$tpl->assign($human);


	$tpl->setLayout('admin');
	$tpl->define("CONTENT", Display::getTemplate("lms/cert_print.htm"));
	
	


	 break;
}
?>