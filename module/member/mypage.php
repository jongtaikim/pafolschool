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

switch ($REQUEST_METHOD) {
	case "GET":
	
	if(!$_SESSION[USERID]){
		echo '<script>alert("로그인이 필요합니다.");history.go(-1)</script>';
		exit;
	}


	if($_SESSION[ADMIN]){
		//$_SESSION[USERID] = ""
	}
	
	$DOC_TITLE="str:마이페이지";
	
	if($ccode){
		$where .= " and num_ccode = '".$ccode."' ";
	}
	
	  $search_key = $_REQUEST['search_key'];
        $search_value = $_REQUEST['search_value'];
        if($search_key && $search_value) {
            if(substr($search_key,0,3) != "num") {
                $where .= "AND $search_key LIKE '%$search_value%' ";
            } else {
                $where .= "AND $search_key = $search_value ";
            }
        }

	$code = $_REQUEST['code'];
	if(!$page = $_REQUEST['page']) $page = 1;

	if(!$listnum)$listnum = 15;
	$sql = "select count(*) from ".$table." where num_oid = '$_OID' and str_id = '".$_SESSION[USERID]."'  $where  ";
	 
	$total = $DB->sqlFetchOne($sql);

	if(!$total) $total = 0;


	$page = $_REQUEST['page'];
	if (!$page) $page = 1;

	$seek = $listnum * ($page - 1);
	$offset = $seek + $listnum;

	$sql = "
	select * from ".$table." where num_oid = '$_OID'  and str_id = '".$_SESSION[USERID]."' $where  order by dt_date desc LIMIT $seek , $listnum   ";

	//echo  $sql;

	$data = $DB->sqlFetchAll($sql);


	
	for($ii=0; $ii<count($data); $ii++) {
		$sql = "select str_title from TAB_LMS_CATE where num_oid = '$_OID' and num_ccode = '".$data[$ii][num_ccode]."' ";
		$data[$ii][str_ccode_text] = $DB -> sqlFetchOne($sql);
		
		$sql = "select * from TAB_CAMP where num_oid = '$_OID' and  num_ccode = '".$data[$ii][num_ccode]."' and num_serial = '".$data[$ii][num_serial]."'";
		$data[$ii][camp] = $DB -> sqlFetch($sql);
		
		
		$data[$ii][camp][start_date] = substr($data[$ii][camp][num_start_date],0,4).". ".substr($data[$ii][camp][num_start_date],4,2).". ".substr($data[$ii][camp][num_start_date],6,2)."";
		$data[$ii][camp][end_date] =  substr($data[$ii][camp][num_end_date],0,4).". ".substr($data[$ii][camp][num_end_date],4,2).". ".substr($data[$ii][camp][num_end_date],6,2)."";
		
		$sql = "select count(*) from $table where num_oid = '$_OID' and str_id = '".$data[$ii][str_id]."' and str_order_st = '1' ";
		$data[$ii][num_counter] = $DB -> sqlFetchOne($sql);


	}
	

	$tpl->assign(array(
	'title'=>$title,
	'LIST'=>$data,
	'page'=>$page,
	'total'=>$total,
	'listnum'=>$listnum
	));
	
	$mcode= "1313";
	$FH = WebApp::singleton('FileHost','menu',$mcode);
	$filepath2 = 'hosts/'.$HOST.'/doc/'.$mcode.'.css';
	$css_text =  @file_get_contents(_DOC_ROOT."/".$filepath2);
	$MSG = WebApp_Message::fromFile(Display::getTemplate('doc/'.$mcode.'.msg'));
	$doc1 = $FH->set_content($MSG->__toString());

	$tpl->assign(array('doc1'=>$doc1));
	
		
	

	$tpl->setLayout('@sub');
	$tpl->define("CONTENT", Display::getTemplate("lms/mypage.htm"));
	



	 break;
	case "POST":

		switch ($mode) {
		
		  case "price_can":
		
		for($ii=0; $ii<count($ids); $ii++) {
			$datas[str_order_st] = 3;
			$DB->updateQuery("TAB_ORDER",$datas," num_oid = '"._OID."' and str_order_code = '".$ids[$ii]."' ");
			$DB->commit();

			
			//unlink(_DOC_ROOT."/hosts/".HOST."/lms/".$types."-".$ids[$ii].".*");
		}
			
		WebApp::moveBack('취소 처리되었습니다..');
		
		 break;
		}
	 break;
	}

?>