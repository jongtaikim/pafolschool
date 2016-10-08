<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2010-01-29
* 작성자: 김종태
* 설   명: 덧글 입력
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');


switch ($REQUEST_METHOD) {
	case "POST":
	
	if(!$_SESSION[USERID]){
	echo "<script>history.go(-1)</script>";
	exit;
	}
	
	$code_url = str_replace("&","|",$code_url);
	if(!$mserial) $serial = WebApp::maxSerial("TAB_COMMENT","num_serial","and num_code='$code_url'");
	$num_group = WebApp::maxSerial("TAB_COMMENT","num_group","and num_code='$code_url'");
	
	$sql = "select max(num_step) from TAB_COMMENT where num_oid = '"._OID."' and num_code='$code_url' ";
	$max_step = $DB -> sqlFetchOne($sql);
	if(!$max_step) $max_step = 1; else $max_step = $max_step +1;
	
	//비속어처리 2009-07-25 종태
	include $_SERVER["DOCUMENT_ROOT"].'/module/bi.php';
	
	
	$content = str_replace("'","''",$content);
      $dt_date = "'".date("Y-m-d H:i:s")."'";
	$ip = getenv('REMOTE_ADDR');
	

	if(!$mserial){
		if(!$main_serial){
		$sql = "INSERT INTO ".TAB_COMMENT." (
			num_oid, num_code , num_serial, num_group, str_user, str_name, str_pass, str_comment, dt_date, str_ip, chr_mtype, str_tmp1,str_tmp2,str_tmp3,num_step 
			) VALUES (
			'"._OID."', '".$code_url."','".$serial ."', '".$num_group ."' , '".$_SESSION[USERID]."' ,'".$cmt_name."' ,'".$cmt_pass."' ,'".$content."', $dt_date, '".$ip."', '".$_SESSION['CHR_MTYPE']."' , '".$str_tmp1."' , '".$str_tmp2."' , '".$str_tmp3."', '".$max_step."'
			) ";
		}else{
			


		
			$sql = "select * from TAB_COMMENT where num_oid = '"._OID."' and num_code='$code_url' and num_group = '".$main_group."' and num_serial = '".$main_serial."' order by num_step desc ";
			$parent_info = $DB -> sqlFetch($sql);
			
			$sql = "select count(*)+1 from TAB_COMMENT where num_oid = '"._OID."' and num_code='$code_url' and num_group = '".$parent_info['num_group']."' and num_step like '".$parent_info['num_step']."|%' ";
			
			$max_step = $DB -> sqlFetchOne($sql);
			
			
			$group = $parent_info['num_group'];
			$depth = (int)$parent_info['num_dtb'] + 1;

			$max_step =  $parent_info['num_step']."|".$max_step;

			$step = $max_step;
		
			
			


			$sql = "INSERT INTO ".TAB_COMMENT." (
			num_oid, num_code , num_serial, num_group, str_user, str_name, str_pass, str_comment, dt_date, str_ip, chr_mtype, str_tmp1,str_tmp2,str_tmp3,num_main_serial , num_dtb,num_step
			) VALUES (
			'"._OID."', '".$code_url."','".$serial ."', '".$group ."' , '".$_SESSION[USERID]."' ,'".$cmt_name."' ,'".$cmt_pass."' ,'".$content."', $dt_date, '".$ip."', '".$_SESSION['CHR_MTYPE']."' , '".$str_tmp1."' , '".$str_tmp2."' , '".$str_tmp3."' , ".$main_serial.", ".$depth.",'".$step."'
			) ";
		}
	
	}else{
	
		
			 $sql = "UPDATE ".TAB_COMMENT." SET str_comment='$content' , dt_date = $dt_date WHERE num_oid="._OID." and num_code='$code_url' and num_serial = '".$mserial."' ";
		
	
	}
	
			 if($DB->query($sql)){
			 $DB->commit();
			
			if(!$mserial){
				//2010-01-29 종태 point 올리기 (board|comment, 올릴수, up|mu)
				WebApp::pointUpdate("comment","1","up");
				
				if($num_main && $mcode){
					$sql = "SELECT COUNT(*) FROM TAB_COMMENT WHERE num_oid="._OID." AND num_code='$code_url'";
					$ttoal = $DB -> sqlFetchOne($sql);

					
					
					$sql = "
						UPDATE TAB_BOARD SET
							num_comment='$ttoal'
						WHERE num_oid="._OID."AND num_mcode=$mcode AND num_serial=$num_main
					";
					$DB->query($sql);
					$DB->commit();
			
					
				}
			}


			WebApp::moveBack();
			exit;
			 
			 }else{
			 echo "sql 에러 : ".$sql;
			 exit;
			 }				
			
	

	 break;
	}

?>
