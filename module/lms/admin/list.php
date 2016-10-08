<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2011-07-11
* 작성자: 김종태
* 설   명: 교육관리
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');

$tpl->assign(array('is_admin'=>'y'));

switch ($REQUEST_METHOD) {
	case "GET":
	


	
	$sql = "select * from ".$table2." where num_oid = '$_OID' order by num_step asc ";
	$row = $DB -> sqlFetchAll($sql);
	$tpl->assign(array('cate_LIST'=>$row));
	
	if($ccode){
		$where = " and num_ccode = '".$ccode."' ";
	}

	$code = $_REQUEST['code'];
	if(!$page = $_REQUEST['page']) $page = 1;

	if(!$listnum)$listnum = 15;

	if($in_num_st) $where .= " and num_st = '".$in_num_st."' ";
	if($sch_num_serial) $where .= " and num_serial = '".$sch_num_serial."' ";
	if($sch_num_ccode) $where .= " and num_ccode = '".$sch_num_ccode."' ";
	if($in_pk) {
		$sql = "select * from ".$table2." where num_oid = '$_OID' and str_title like '%+%' order by num_step asc ";
		$crow = $DB -> sqlFetchAll($sql);
		for($ii=0; $ii<count($crow); $ii++) {
			$psr .= $crow[$ii][num_ccode].",";
		}
		$where .= " and num_ccode in  (".$psr." 0 ) ";
		

	}


	$sql = "select count(*) from ".$table." where num_oid = '$_OID' $where  ";
	$total = $DB->sqlFetchOne($sql);
	if(!$total) $total = 0;


	$page = $_REQUEST['page'];
	if (!$page) $page = 1;

	$seek = $listnum * ($page - 1);
	$offset = $seek + $listnum;

	$sql = "
	select * from ".$table." where num_oid = '$_OID'  $where order by num_serial desc LIMIT $seek , $listnum   ";

	//echo  $sql;

	$data = $DB->sqlFetchAll($sql);
	
	for($ii=0; $ii<count($data); $ii++) {
		$sql = "select str_title from TAB_LMS_CATE where num_oid = '$_OID' and num_ccode = '".$data[$ii][num_ccode]."' ";
		$data[$ii][str_ccode_text] = $DB -> sqlFetchOne($sql);

		$data[$ii][start_date] = substr($data[$ii][num_start_date],0,4)."년 ".substr($data[$ii][num_start_date],4,2)."월 ".substr($data[$ii][num_start_date],6,2)."일";
		$data[$ii][end_date] =  substr($data[$ii][num_end_date],0,4)."년 ".substr($data[$ii][num_end_date],4,2)."월 ".substr($data[$ii][num_end_date],6,2)."일";

	}
	

	$tpl->assign(array(
	'title'=>$title,
	'LIST'=>$data,
	'page'=>$page,
	'total'=>$total,
	'listnum'=>$listnum
	));
	
	$tpl->setLayout('no3');
	$tpl->define("CONTENT", Display::getTemplate("lms/admin/list.htm"));






	 break;
	case "POST":
	
		switch ($mode) {
		case "delete":
		
			
		for($ii=0; $ii<count($ids); $ii++) {
			$DB->deleteQuery($table," num_oid = '"._OID."' and num_serial = '".$ids[$ii]."' ");
			$DB->commit();
			unlink(_DOC_ROOT."/hosts/".HOST."/lms/".$types."-".$ids[$ii].".*");
		}
			
			
		WebApp::moveBack('삭제되었습니다.');
		
		 break;
		}


	 break;
	}

?>