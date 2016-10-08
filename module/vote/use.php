<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2009-08-10
* 작성자: 김종태
* 설   명: 온라인투표하기
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');


switch ($REQUEST_METHOD) {
	case "GET":
	
	if($serial){
	$sql = "select * from TAB_VOTE where num_oid = $_OID and num_serial = $serial";
	$data = $DB -> sqlFetch($sql);
	$data[num_start_date] = date("Y-m-d",$data[num_start_date]);
	$data[num_end_date] = date("Y-m-d",$data[num_end_date]);
	$tpl->assign($data);
	}
	
	$sql = "select * from TAB_VOTE_USER where num_oid = $_OID and num_serial = $serial order by num_user_number asc  ";
	$row_d = $DB -> sqlFetchAll($sql);
	

	for($ii=0; $ii<count($row_d); $ii++) {
         $row[$ii][num_serial] = $serial;
         $row[$ii][num_user_number] = ($ii+1);
         $row[$ii][str_name] = $row_d[$ii][str_name];
		 $ia = $ii+1;
		if(is_file(_DOC_ROOT."/hosts/".HOST."/files/vote/".$serial."_".$ia.".gif")) {
		$row[$ii][img] = "/hosts/".HOST."/files/vote/".$serial."_".$ia.".gif";
		}else{
		$row[$ii][img] = "/image/noimage.gif";
		}

	}

	$tpl->assign(array(
	 'LIST'=>$row,
	 'serial'=>$serial,
	 ));
	


	$tpl->setLayout('admin_xhtml');
	$tpl->define("CONTENT", Display::getTemplate("vote/use.htm"));
	
	 break;
	case "POST":





	
	$sql = "select count(*) from TAB_VOTE_DATA where num_oid = $_OID and num_serial = '$serial' and  str_code = '$code' ";
	$chk = $DB -> sqlFetchOne($sql);
	
	if($chk) {
	echo '<script>alert("이미 투표하신 목록입니다.");</script>';
	echo "<meta http-equiv='Refresh' Content=\"0; URL='/vote.view'\">";
	exit;
		
	}else{
	
	$sql = "INSERT INTO ".TAB_VOTE_DATA." (
		num_oid ,num_serial, str_code ,num_chk
		) VALUES (
		"._OID.", '$serial','$code','$user_number'		
		) ";


		 if($DB->query($sql)){
		 $DB->commit();
		 echo '<script>alert("성공적으로 적용되었습니다.");</script>';
		 echo "<meta http-equiv='Refresh' Content=\"0; URL='/vote.view'\">";
		 exit;
		 }else{
		 echo "sql 에러 : ".$sql;
		 exit;
		 }				
		
	
	

	}
	
	


	 break;
	}

?>