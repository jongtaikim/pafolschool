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
	
	$sql = "select * from TAB_LMS_CATE where num_oid = '$_OID' order by num_step asc";
	$row = $DB -> sqlFetchAll($sql);
	$tpl->assign(array('cate_LIST'=>$row));

	if($ccode){
		$add_where = " and num_ccode = '".$ccode."' ";
	}


	$table = "TAB_TACH";
	if(!$page = $_REQUEST['page']) $page = 1;

	if(!$listnum) $listnum = 20;
	$sql = "select count(*) from ".$table." where num_oid = '$_OID'   $add_where  ";

	$total = $DB->sqlFetchOne($sql);

	if(!$total) $total = 0;


	$page = $_REQUEST['page'];
	if (!$page) $page = 1;

	$seek = $listnum * ($page - 1);
	$offset = $seek + $listnum;

	$sql = "
	select * from ".$table." where num_oid = '$_OID'   $add_where order by num_serial  desc LIMIT $seek , $listnum   ";

	

	$row = $DB -> sqlFetchAll($sql);

	$tpl->assign(array('LIST'=>$row));
	$tpl->assign(array('total'=>$total));
	$tpl->assign(array('listnum'=>$listnum));
	
		

	$tpl->setLayout('no3');
	$tpl->define("CONTENT", Display::getTemplate("lms/admin/tach.htm"));
	
	 break;
	case "POST":

		switch ($mode) {
		case "delete":
		
			
		for($ii=0; $ii<count($ids); $ii++) {
			$DB->deleteQuery("TAB_TACH"," num_oid = '"._OID."' and num_serial = '".$ids[$ii]."' ");
			$DB->commit();

			/*$DB->deleteQuery("TAB_LMS_HUMAN"," num_oid = '"._OID."' and str_order_code = '".$ids[$ii]."' ");
			$DB->commit();*/
			//unlink(_DOC_ROOT."/hosts/".HOST."/lms/".$types."-".$ids[$ii].".*");
		}
		 break;
		}

		WebApp::moveBack();
		
	 break;
	}


?>