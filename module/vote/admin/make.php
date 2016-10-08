<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2009-08-10
* 작성자: 김종태
* 설   명: 온라인 투표 등록
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');
$FH = &WebApp::singleton('FileHost','main','vote');

switch ($REQUEST_METHOD) {
	case "GET":
	
	if($serial){
	 $sql = "select * from TAB_VOTE where num_oid = $_OID and num_serial = $serial";
	$data = $DB -> sqlFetch($sql);
	$data[num_start_date] = date("Y-m-d",$data[num_start_date]);
	$data[num_end_date] = date("Y-m-d",$data[num_end_date]);
	$tpl->assign($data);
	}
	
	

	$tpl->setLayout('no3');
	$tpl->define("CONTENT", Display::getTemplate("vote/admin/make.htm"));
	$tpl->assign(array(
		'serial'=>$serial,

	 ));
	
	
	 break;
	case "POST":
	
	$num_start_date = WebApp::mkday($num_start_date);
	$num_end_date = WebApp::mkday($num_end_date);
	
	
    if(!$serial){
	
	$max_serial = WebApp::maxSerial("TAB_VOTE","num_serial");
	$str_text = WebApp::ImgChaneDe($str_text, $max_serial);

	$sql = "INSERT INTO ".TAB_VOTE." (
				num_oid ,num_serial, str_title, num_user , dt_date, num_start_date, num_end_date,str_text
				) VALUES (
				"._OID." ,".$max_serial.", '$str_title', '$num_user' , ".mktime().", '$num_start_date', '$num_end_date','$str_text'
				) ";
	
				if($DB->query($sql)){
				$DB->commit();
				echo '<script>alert("저장되었습니다.");</script>';
				echo "<meta http-equiv='Refresh' Content=\"0; URL='vote.admin.make2?serial=$max_serial'\">";
				exit;
				}
	
	
	}else{
	

	$sql = "select count(*) from TAB_VOTE_DATA where num_oid = $_OID and num_serial = $serial";
	$count = $DB -> sqlFetchOne($sql);

	if($count<1){
	
	$str_text = WebApp::ImgChaneDe($str_text, $serial);
	 $sql = "UPDATE ".TAB_VOTE." SET 

		str_title = '$str_title', 
		num_user = '$num_user', 

		num_start_date = '$num_start_date', 
		num_end_date  = '$num_end_date',
		str_text = '$str_text'
	  WHERE num_oid=$_OID and num_serial = $serial";


		 if($DB->query($sql)){
		 $DB->commit();
		 echo '<script>alert("수정되었습니다.");</script>';
		 echo "<meta http-equiv='Refresh' Content=\"0; URL='vote.admin.make2?serial=$serial'\">";
		 exit;
		
		 }else{
		 echo "sql 에러 : ".$sql;
		 exit;
		 }



		}else{
		
		WebApp::moveBack('투표가 이미 시작되어 수정 불가합니다.');
		

		}
	}
	
	
	break;
	}

?>