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

$table = "TAB_LMS_HUMAN";

switch ($REQUEST_METHOD) {
	case "GET":
	


	$sql = "
	select a.num_lms_code , count(*) as counter from ".$table." a, TAB_LMS_ORDER b 
	
	where a.num_oid = '$_OID'  and 
	a.num_oid = b.num_oid and 
	a.str_order_code = b.str_order_code and 
	a.str_commit = 'n'  and
	b.str_order_st = '1'
	
	group by a.num_lms_code
	 order by a.num_lms_code desc   ";


	$data = $DB->sqlFetchAll($sql);
	
	for($ii=0; $ii<count($data); $ii++) {
		$sql = "select * from TAB_LMS where num_oid = '$_OID' and num_serial = '".$data[$ii][num_lms_code]."' ";
		$data[$ii][lms] = $DB -> sqlFetch($sql);

		$sql = "select str_title from TAB_LMS_CATE where num_oid = '$_OID' and num_ccode = '".$data[$ii][lms][str_title]."' ";
		$data[$ii][lms][str_title] = $DB -> sqlFetchOne($sql);

	}
	

	$tpl->assign(array(
	'title'=>$title,
	'LIST'=>$data,
	'page'=>$page,
	'total'=>$total,
	'listnum'=>$listnum
	));
	
	

	$tpl->setLayout('no3');
	$tpl->define("CONTENT", Display::getTemplate("lms/admin/cert.htm"));
	
	 break;
	case "POST":

		switch ($mode) {
		case "delete":
		
			
		for($ii=0; $ii<count($ids); $ii++) {
			$DB->deleteQuery("TAB_LMS_ORDER"," num_oid = '"._OID."' and str_order_code = '".$ids[$ii]."' ");
			$DB->commit();

			$DB->deleteQuery("TAB_LMS_HUMAN"," num_oid = '"._OID."' and str_order_code = '".$ids[$ii]."' ");
			$DB->commit();
			//unlink(_DOC_ROOT."/hosts/".HOST."/lms/".$types."-".$ids[$ii].".*");
		}
			
			
		WebApp::moveBack('삭제되었습니다.');
		
		 break;
		 case "price_in":
		
			
		for($ii=0; $ii<count($ids); $ii++) {
			$datas[str_order_st] = 1;
			$DB->updateQuery("TAB_LMS_ORDER",$datas," num_oid = '"._OID."' and str_order_code = '".$ids[$ii]."' ");
			$DB->commit();

			
			//unlink(_DOC_ROOT."/hosts/".HOST."/lms/".$types."-".$ids[$ii].".*");
		}
			
			
		WebApp::moveBack('입금확인 처리되었습니다..');
		
		 break;
		  case "price_out":
		
			
		for($ii=0; $ii<count($ids); $ii++) {
			$datas[str_order_st] = 0;
			$DB->updateQuery("TAB_LMS_ORDER",$datas," num_oid = '"._OID."' and str_order_code = '".$ids[$ii]."' ");
			$DB->commit();

			
			//unlink(_DOC_ROOT."/hosts/".HOST."/lms/".$types."-".$ids[$ii].".*");
		}
			
			
		WebApp::moveBack('미입금확인 처리되었습니다..');
		
		 break;
		  case "price_can":
		
		for($ii=0; $ii<count($ids); $ii++) {
			$datas[str_order_st] = 3;
			$DB->updateQuery("TAB_LMS_ORDER",$datas," num_oid = '"._OID."' and str_order_code = '".$ids[$ii]."' ");
			$DB->commit();

			
			//unlink(_DOC_ROOT."/hosts/".HOST."/lms/".$types."-".$ids[$ii].".*");
		}
			
		WebApp::moveBack('취소 처리되었습니다..');
		
		 break;
		}
	 break;
	}

?>