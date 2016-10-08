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
	if(!$ccode1) $ccode1 = 10;
	if(!$ccode2) $ccode2 = 1010;

	$tpl->assign(array(
		'types'=>$types,
		'ccode1'=>$ccode1,
		'ccode2'=>$ccode2,
	 ));

	$sql = "select * from TAB_LMS_CATE where num_oid = '$_OID' and str_type = '$types' and   LENGTH(NUM_CCODE)=2 order by num_step asc";
	$row = $DB -> sqlFetchAll($sql);
	$tpl->assign(array('cate1_LIST'=>$row));

	$sql = "select * from TAB_LMS_CATE where num_oid = '$_OID' and LENGTH(NUM_CCODE)=4 order by num_step asc";
	$row = $DB -> sqlFetchAll($sql);
	$tpl->assign(array('cate2_LIST'=>$row));
	
	

	$sql = "select * from TAB_LMS where num_oid = '$_OID' and str_type = '$types' and num_ccode = '".$ccode1."' and str_title = '".$ccode2."' ";
	$row = $DB -> sqlFetchAll($sql);
	for($ii=0; $ii<count($row); $ii++) {
		
		$sql = "select str_title from TAB_LMS_CATE where num_oid = '$_OID' and num_ccode = '".$row[$ii][str_title]."' ";
		$row[$ii][str_title] = $DB -> sqlFetchOne($sql);
	}
	
	$tpl->assign(array('LIST'=>$row));
	
	
	

	$tpl->setLayout('@sub');
	$tpl->define("CONTENT", Display::getTemplate("lms/list.htm"));
	
	 break;
	case "POST":
	 break;
	}

?>