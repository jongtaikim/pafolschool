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
	
	if($serial){
	
	$sql = "select * from TAB_TEXT_DB where num_oid = '$_OID' and num_mcode = '$mcode' and num_serial ='".$serial."' ";
	$data = $DB -> sqlFetch($sql);
	$tpl->assign($data);
	}
	
	


	$tpl->setLayout('@sub');
	$tpl->define("CONTENT", Display::getTemplate("text_db/add.htm"));
	
	 break;
	case "POST":

	

	 if(!$serial){

	 $data[num_oid] = _OID;
	 $data[num_mcode] = $mcode;
	 $sql = "select max(num_serial) +1 from TAB_TEXT_DB where num_oid = '$_OID' and num_mcode = '$mcode'";
	 $data[num_serial] = $DB -> sqlFetchOne($sql);
	 if(!$data[num_serial]) $data[num_serial] = 1;
	 $data[str_index] = $str_index;
	 $data[str_word] = $str_word;
	 $data[str_text] = $str_text;
	 $data[num_date] = mktime();

	 $DB->insertQuery("TAB_TEXT_DB", $data);
	 $DB->commit();

	

	 }else{
	
	 $data[str_index] = $str_index;
	 $data[str_word] = $str_word;
	 $data[str_text] = $str_text;
	 $data[num_date] = mktime();
	
	 $DB->updateQuery("TAB_TEXT_DB",$data," num_oid = '"._OID."' and num_serial = '$serial' ");
	 $DB->commit();

	
	 }


	  //2011-07-11 종태 검색엔진에 키워드 등록
	$sch_data[num_oid] = _OID;
	$sch_data[str_url] = "/text_db.list?mcode=".$mcode."&word=".$str_index."&keyword=".$str_word;
	$sch_data[str_type] = "text_db";
	$sch_data[str_title] = "[용어사전] ".$str_word;
	$sch_data[str_text] = strip_tags($str_text);
	$sch_data[num_date] = date("Ymd");
	$sch_data[num_hit] = 0;

	$DB->insertQuery("TAB_SCH",$sch_data);
	$DB->commit();

 	 //2011-07-11 종태 검색엔진에 키워드 등록
	$sch_datas[str_url] = "/text_db.list?mcode=".$mcode."&word=".$str_index."&keyword=".$str_word;
	$sch_datas[str_title] = "[용어사전] ".$str_word;
	$sch_datas[str_text] = strip_tags($str_text);
	$sch_datas[num_date] = date("Ymd");

	$DB->insertQuery("TAB_SCH",$sch_datas," num_oid = '"._OID."' and str_url = '".$sch_datas[str_url]."' ");
	$DB->commit();
	 
	 echo '<script>alert("적용되었습니다.");</script>';
	echo "<meta http-equiv='Refresh' Content=\"0; URL='/text_db.list?mcode=$mcode&cate=$cate'\">";
	 
	 
	 break;
	}

?>