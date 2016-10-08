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

$table = "TAB_LMS_ORDER";
$table2 = "TAB_LMS";
$table3 = "TAB_LMS_CATE";
$table4 = "TAB_LMS_HUMAN";

switch ($REQUEST_METHOD) {
	case "GET":
	
	if(!$types){
		$types = "1";
	}

	$sql = "
	select * from ".$table2." where num_oid = '$_OID'  and num_serial = '".$lms_code."' ";
	$data = $DB->sqlFetch($sql);
	$num_ccode = $data[num_ccode];

	$sql = "select * from TAB_LMS where num_oid = '$_OID' and num_serial = '".$lms_code."' ";
	$datas = $DB -> sqlFetch($sql);

	$sql = "select str_title from TAB_LMS_CATE where num_oid = '$_OID' and num_ccode = '".$datas[str_title]."' ";
	$datas[str_title] = $DB -> sqlFetchOne($sql);

	$tpl->assign($data);
	$tpl->assign($datas);

	

	$sql = "
	select * from ".$table4." where num_oid = '$_OID'  and num_lms_code = '".$lms_code."' ";
	$data = $DB->sqlFetchAll($sql);

	$tpl->assign(array('human_LIST'=>$data));

	
	

	$tpl->setLayout('no3');
	$tpl->define("CONTENT", Display::getTemplate("lms/admin/cert_view.htm"));
	
	 break;
	case "POST":
	

	switch ($mode) {
	case "access":
	for($ii=0; $ii<count($ids); $ii++) {
	
		$datas[$ii][str_commit] = 'y';
		$DB->updateQuery("TAB_LMS_HUMAN",$datas[$ii]," num_oid = '"._OID."' and num_lms_code = '".$lms_code."' and num_serial = '".$ids[$ii]."'");
		$DB->commit();
	
	}
	
	
	 break;
	case "not_access":
	 for($ii=0; $ii<count($ids); $ii++) {
		$datas[$ii][str_commit] = 'n';
		$DB->updateQuery("TAB_LMS_HUMAN",$datas[$ii]," num_oid = '"._OID."' and num_lms_code = '".$lms_code."' and num_serial = '".$ids[$ii]."'");
		$DB->commit();
	}
	 break;
	}
	

	if($all_commit == "y"){
		$datass[str_lms_st] = "y";
		$DB->updateQuery("TAB_LMS",$datass," num_oid = '"._OID."' and num_serial = '".$lms_code."'");
		$DB->commit();
	}
	
	

	echo '<script>alert("저장되었습니다.");</script>';
	echo "<meta http-equiv='Refresh' Content=\"0; URL='/lms.admin.cert_view?lms_code=$lms_code'\">";
	
	 break;
	}

?>