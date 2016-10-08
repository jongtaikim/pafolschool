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
$table = "TAB_CAMP";
$table2 = "TAB_LMS_CATE";

switch ($REQUEST_METHOD) {
	case "GET":
	


	if(strstr($ccode,",")){
		$where = " and num_ccode  in(".$ccode.") ";
		$tpl->assign(array('no_tab'=>"y"));
		
		 
	}else{
		if($ccode){
			$where = " and num_ccode = '".$ccode."' ";
		}
	}

	//$where .= " and num_start_date > ".date("Ymd")." ";

	$code = $_REQUEST['code'];
	if(!$page = $_REQUEST['page']) $page = 1;

	if(!$listnum)$listnum = 15;
	$sql = "select count(*) from ".$table." where num_oid = '$_OID' $where and str_view = 'y' ";

	$total = $DB->sqlFetchOne($sql);
	if(!$total) $total = 0;


	$page = $_REQUEST['page'];
	if (!$page) $page = 1;

	$seek = $listnum * ($page - 1);
	$offset = $seek + $listnum;
	
	if($_GET[study]){
		$ob = " order by num_step asc ";
	}else{
		$ob = " order by num_serial desc ";
	}

	$sql = "
	select * from ".$table." where num_oid = '$_OID'  $where  and str_view = 'y' $ob LIMIT $seek , $listnum   ";



	$data = $DB->sqlFetchAll($sql);
	
	for($ii=0; $ii<count($data); $ii++) {
		$sql = "select str_title from TAB_LMS_CATE where num_oid = '$_OID' and num_ccode = '".$data[$ii][num_ccode]."' ";
		$data[$ii][str_ccode_text] = $DB -> sqlFetchOne($sql);

		$data[$ii][start_date] = substr($data[$ii][num_start_date],0,4)."년 ".substr($data[$ii][num_start_date],4,2)."월 ".substr($data[$ii][num_start_date],6,2)."일";
		$data[$ii][end_date] =  substr($data[$ii][num_end_date],0,4)."년 ".substr($data[$ii][num_end_date],4,2)."월 ".substr($data[$ii][num_end_date],6,2)."일";

		if(strstr($data[$ii][str_ccode_text],":")){
			$a = explode(":",$data[$ii][str_ccode_text]);
			$data[$ii][str_ccode_text] = $a[1];
			$data[$ii][str_ccode_text_2] = $a[0];
				
		}

	}
	

	$tpl->assign(array(
	'title'=>$title,
	'LIST'=>$data,
	'page'=>$page,
	'total'=>$total,
	'listnum'=>$listnum
	));
	
	
	
	

	$tpl->setLayout('@sub');
	$tpl->define("CONTENT", Display::getTemplate("lms/order.htm"));
	
	 break;
	case "POST":

	 include 'module/file.php';
	 

	 
	if(!$types) $types = 1;

	 $sql = "select * from TAB_LMS where num_oid = '$_OID' and str_type = '$types' and num_serial = '".$serial."'";
	$data = $DB -> sqlFetch($sql);

	$datas[num_oid] = _OID;
	$datas[str_order_code] = date("YmdHis");
	$datas[num_ccode] = $data[num_ccode];
	$datas[num_lms_code] = $data[num_serial];
	$datas[str_order_title] = $_POST[str_order_title];
	$datas[str_compay] = $_POST[str_company];
	$datas[str_company_number] = $_POST[str_company_number];
	$datas[str_order_st] = 0;
	$datas[str_type] = $types;
	$datas[num_order_price] = $data[num_price];

	
	$datas[str_userid] = $_SESSION[USERID];
	$datas[str_name] = $_POST[str_name];
	$datas[num_date] = mktime();
	$datas[str_order_phone] = $_POST[str_order_phone];
	$datas[str_order_email] = $_POST[str_order_email];
	$datas[str_tax_send] = 0;

	if($upfile1) {
			$file = new FileUpload("upfile1"); // datafile은 form에서의 이름 
			$file->Path = _DOC_ROOT."/hosts/".HOST."/lms/order/";  // 마지막에 /꼭 붙여야함

		//$file->file_mkdir(); 
		if(!$file->Ext("gif,png,jpg"))  {
			echo '<script>alert("이미지 파일만 업로드 가능합니다."); </script>';
			exit;
		 }

		$fidx = $datas[str_order_code];
		$file->file_renameExp($fidx); 
		if(!$file->upload()){
			echo '<script>alert("업로드에 실패 했습니다."); </script>';
			exit;
		}
		$file->upload();

		
		
		$datas[str_saup_img] = $file->SaveName;
		}
	$iia = 0;
	for($ii=0; $ii<count($names); $ii++) {
		$human[$ii][num_oid] = _OID;
		$human[$ii][str_order_code] = $datas[str_order_code];
		$human[$ii][num_serial] = ($ii +1);
		$human[$ii][str_name] = $_POST[names][$ii];
		$human[$ii][str_compay] = $datas[str_compay];
		$human[$ii][str_term] = $_POST[terms][$ii];
		$human[$ii][str_ups] = $_POST[ups][$ii];
		$human[$ii][str_email] = $_POST[emails][$ii];
		$human[$ii][str_phone] = $_POST[phones][$ii];
		$human[$ii][num_lms_serial] = $data[num_serial];
		
		

		if($human[$ii][str_name]){
			$iia +1;
			$DB->insertQuery("TAB_LMS_HUMAN",$human[$ii]);
			$DB->commit();
		}
		
 	}
	$sql = "select count(*) from TAB_LMS_HUMAN where num_oid = '$_OID' and str_order_code = '".$datas[str_order_code]."' ";
	$datas[num_human]  = $DB -> sqlFetchOne($sql);
	
	$datas[num_order_price] = $datas[num_order_price] * $datas[num_human];

	$DB->insertQuery("TAB_LMS_ORDER",$datas);
	$DB->commit();
	
	
	

	echo '<script>alert("신청이 완료되었습니다.");</script>';
	echo "<meta http-equiv='Refresh' Content=\"0; URL='/main'\">";
	 


	 
	 
	 break;
	}

?>