<?
//2008-01-04 종태
/**********************************
새로운 학교 관리자

프로그램 : 종태 
디자인 : 선화
**********************************/

function byte_convert($bytes){
	$symbol = array('byte', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');

	$exp = 0;
	$converted_value = 0;
	if( $bytes > 0 ){
		$exp = floor( log($bytes)/log(1024) );
		$converted_value = ( $bytes/pow(1024,floor($exp)) );
	}
	if($bytes) {
		return sprintf( '%.2f'.$symbol[$exp], $converted_value );		
	}

	//return sprintf( '%d'.$symbol[$exp], $converted_value );
}



$_UCC = WebApp::getConf('ucc');
$ucc  = $_UCC['ucc'];

$tpl->assign(array('ucc'=>$ucc));
$tpl->assign(array('ucc_admin_url'=>'http://'._MOV_URL.'/uadmin/login_proc.php?userid='.$_UCC[ucc_id].'&password='.$_UCC[ucc_pw]));

//2008-10-28  종태 회원권한 관리자에 표기
$_member_type = WebApp::getConf('member_type');
$tpl->assign(array('gname'=>$_member_type[$_SESSION['CHR_MTYPE']]));

$sql = "select num_disk,num_upload_size,str_end_date from TAB_ORGAN where num_oid = $_OID ";

//$disk_db = $DB -> sqlFetch($sql);
$disk_db[num_disk] = byte_convert($disk_db[num_disk]);
$disk_db[num_upload_size] = byte_convert($disk_db[num_upload_size]);
$tpl->assign($disk_db);



$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));






	
	$DB = &WebApp::singleton('DB');
	//입력데이터를 가진 메뉴 호출
	$sql = "SELECT num_mcode, str_title FROM TAB_MENU WHERE num_oid=$_OID and str_type='form'";
	if($data1 = $DB->sqlFetchAll($sql)) array_walk($data1,'list_format'); // 데이터가공
	$title1 = "데이터관리"; 




	$sql = media_sql('offline');

	if($data2 = $DB->sqlFetchAll($sql)) array_walk($data2,'list_format_media'); // 데이터가공

	$title2 = "오프라인 강좌 신청관리"; 





	//동영상관리 리스트출력
	$sql = media_sql('online');
	if($data3 = $DB->sqlFetchAll($sql)) array_walk($data3,'list_format_media'); // 데이터가공
	
	if(_OID >=20252) {$title3 = "LIVE 강좌 신청관리"; }else{$title3 = "영상 강좌 신청관리"; }


	//동영상관리 리스트출력
	$sql = media_sql('book');
	if($data4 = $DB->sqlFetchAll($sql)) array_walk($data4,'list_format_media'); // 데이터가공

	if(_OID >=20252) {$title4 = "주문 신청관리"; ; }else{$title4 = "도서 신청관리"; }
	

	$tpl->setLayout('no'); // 레이아웃은 서브


		$tpl->define("CONTENT", WebApp::getTemplate("admin/main2.htm"));


	$tpl->assign(array(
		'organ'=>$organ,
		'title1'=>$title1,
		'title2'=>$title2,
		'title3'=>$title3,
		'title4'=>$title4,

		'data1'=>$data1,
		'data2'=>$data2,
		'data3'=>$data3,
		'data4'=>$data4,
		
	));



function list_format(&$arr) {
	global $_OID,$DB;
	
	//어제까지 데이터
	$chkdate = mktime(0, 0, 0, date("m"), date("d")-3, date("Y"));
	$sql = "SELECT count(*) FROM TAB_FORM WHERE num_oid=$_OID and num_mcode='".$arr[num_mcode]."' and dt_date>'$chkdate'";
	$arr['formcount'] = $DB->sqlFetchOne($sql);

	$arr['str_title'] = $arr['str_title']."(신규:".number_format($arr['formcount'])."건) ";
	$arr['link'] = "javascript:winOpen('/form.admin.list?mcode=".$arr['num_mcode']."',800,600,'yes')";
}



function list_format_media(&$arr) {
	global $DB,$_OID;
	/*if($arr['num_st'] == '0') $arr['num_st'] ="입금확인전";
	elseif($arr['num_st'] == '1') $arr['num_st'] ="입금확인";
	elseif($arr['num_st'] == '2') $arr['num_st'] ="카드승인";
	elseif($arr['num_st'] == '3') $arr['num_st'] ="취소";
	elseif($arr['num_st'] == '4') $arr['num_st'] ="서비스";
	*/
	//$arr['str_title'] = $arr['str_option']." / ".$arr['str_name']." / ".$num_st." / ".number_format($arr['num_price']);	//상품,신청자,주문상태,결제금액

	$chkdate = mktime(0, 0, 0, date("m"), date("d")-3, date("Y"));
	if($arr['dt_date'] >$chkdate) {
		$arr['new2'] = "y";
	}
	
	
	if(_OID >= 20252) {
	

		
	//스탁스토리 인경우
	if($arr[str_order_type] == "media") {
	$arr['link'] = "/lms.admin.order_m_view?num_order_number=".$arr['num_order_number']."&serial=".$arr['num_serial']."&PageNum=060200";	
	}else  {

	if($arr['num_media_type'] == 1) {
	$arr['link'] = "/lms.admin.order_m_view_off?num_order_number=".$arr['num_order_number']."&serial=".$arr['num_serial']."&PageNum=060100";				
	}else{
	$arr['link'] = "/lms.admin.order_m_view?num_order_number=".$arr['num_order_number']."&serial=".$arr['num_serial']."&PageNum=060100";		
	}

	}
	
	
	}else{
	//2009-03-26 예전시스템일경우	
	if($arr[num_media_type] == "1") {
	$arr['link'] = "/lms.admin.order_m_view_off?num_order_number=".$arr['num_order_number']."&serial=".$arr['num_serial']."&PageNum=060100";	
	}else  {
	$arr['link'] = "/lms.admin.order_m_view?num_order_number=".$arr['num_order_number']."&serial=".$arr['num_serial']."&PageNum=060100";		
	}

		
	}


	$sql = "select str_title,str_title2 from TAB_MEDIA_CONFIG where num_oid = '$_OID' and num_ccode = '".$arr[num_ccode]."' ";

	$t_data = $DB -> sqlFetch($sql);
	$arr['str_title'] = $t_data[str_title];
	$arr['str_title2'] = $t_data[str_title2];
	
	
}



function media_sql($set){
	global $_OID;

	if($set == 'online') {
		$sql = "
				SELECT a.* 
				  FROM 
					   (SELECT ROWNUM AS RNUM, 
							  b.* 
						 FROM 
							  (SELECT  *
								FROM TAB_MEDIA_ORDER 
							   WHERE num_oid = $_OID  
							   and num_media_type != 1
							   and num_media_type != 3
							   and str_order_type is NULL
							ORDER BY num_serial desc 
							  )b
					   )a 
				 WHERE a.RNUM <= 5 ";
	}



	else if ( $set == 'book' ) {
		
		if(_OID >= 20252){
		$sql = "
				SELECT a.* 
				  FROM 
					   (SELECT ROWNUM AS RNUM, 
							  b.* 
						 FROM 
							  (SELECT  *
								FROM TAB_MEDIA_ORDER 
							   WHERE num_oid = $_OID  
							   and num_media_type != 1
							   and num_media_type != 3
							    and str_order_type = 'media'
							ORDER BY num_serial desc 
							  )b
					   )a 
				 WHERE a.RNUM <= 5 ";

		}else{
		
		$sql = "
				SELECT a.* 
				FROM 
					(SELECT ROWNUM AS RNUM, 
							b.* 
						 FROM 
							(SELECT o.num_order_number, 
									 o.num_serial, 
									 o.num_ccode, 
									 o.str_id, 
									 o.dt_date, 
									 o.num_st, 
									 o.chr_zip, 
									 o.str_addr1, 
									 o.str_addr2, 
									 o.num_bank_number, 
									 o.str_bank_name, 
									 o.dt_bank_day, 
									 o.num_view_end, 
									 o.dt_start_day, 
									 o.str_phone, 
									 o.str_handphone, 
									 o.str_memo, 
									 o.num_order_price, 
									 o.num_order_sale, 
									 o.num_order_type, 
									 o.num_media_type, 
									 o.str_tach_code, 
									 o.str_book_code, 
									 o.num_book_price, 
									 o.num_st_tak, 
									 o.str_option, 
									 o.str_pg_return, 
									 o.num_point_use, 
									 o.num_mcode, 
									 o.str_name, 
									 o.str_su_number, 
									 o.str_off_st, 
									 o.str_text, 
									 o.str_re_order, 
									 o.num_option_number,
									 c.str_name AS str_bookname 
								FROM TAB_MEDIA_ORDER o, 
									 TAB_BOOK c 
							WHERE o.num_oid = $_OID 
									 AND o.num_media_type = 3 
									 AND o.str_book_code = c.str_book_code 
									 AND o.num_oid = c.num_oid 
							ORDER BY num_serial desc 
							)b 
					)a 
				WHERE a.RNUM <= 5 ";

		}

	}
	else {
		$sql = "
				SELECT a.* 
				  FROM 
					   (SELECT ROWNUM AS RNUM, 
							  b.* 
						 FROM 
							  (SELECT  *
								FROM TAB_MEDIA_ORDER 
							   WHERE num_oid = $_OID  
							   and num_media_type = 1
							ORDER BY num_serial desc 
							  )b
					   )a 
				 WHERE a.RNUM <= 5 ";
	}

	return $sql;
}
?>
