<?
//2008-01-04 ����
/**********************************
���ο� �б� ������

���α׷� : ���� 
������ : ��ȭ
**********************************/

$_UCC = WebApp::getConf('ucc');
$ucc  = $_UCC['ucc'];

$tpl->assign(array('ucc'=>$ucc));
$tpl->assign(array('ucc_admin_url'=>'http://'._MOV_URL.'/uadmin/login_proc.php?userid='.$_UCC[ucc_id].'&password='.$_UCC[ucc_pw]));

//2008-10-28  ���� ȸ������ �����ڿ� ǥ��
$_member_type = WebApp::getConf('member_type');
$tpl->assign(array('gname'=>$_member_type[$_SESSION['CHR_MTYPE']]));



if($_OID == 3) {

	echo "<meta http-equiv='Refresh' Content=\"0; URL='/sadmin.main'\">";
	exit;
	

}else{
	
	$DB = &WebApp::singleton('DB');
	//�Էµ����͸� ���� �޴� ȣ��
	$sql = "SELECT num_mcode, str_title FROM TAB_MENU WHERE num_oid=$_OID and str_type='form'";
	if($data1 = $DB->sqlFetchAll($sql)) array_walk($data1,'list_format'); // �����Ͱ���
	$title1 = "�����Ͱ���"; 




	$sql = media_sql('offline');
	if($data2 = $DB->sqlFetchAll($sql)) array_walk($data2,'list_format_media'); // �����Ͱ���

	$title2 = "�������� ���� ��û����"; 





	//��������� ����Ʈ���
	$sql = media_sql('online');
	if($data3 = $DB->sqlFetchAll($sql)) array_walk($data3,'list_format_media'); // �����Ͱ���
	$title3 = "�¶��� ���� ��û����"; 


	//��������� ����Ʈ���
	$sql = media_sql('book');
	if($data4 = $DB->sqlFetchAll($sql)) array_walk($data4,'list_format_media'); // �����Ͱ���
	$title4 = "���� ��û����"; 

	$tpl->setLayout('no'); // ���̾ƿ��� ����
	$tpl->define("CONTENT", WebApp::getTemplate("admin2/main_work.htm"));
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
}

function list_format(&$arr) {
	global $_OID,$DB;
	
	//�������� ������
	$chkdate = mktime(0, 0, 0, date("m"), date("d")-3, date("Y"));
	$sql = "SELECT count(*) FROM TAB_FORM WHERE num_oid=$_OID and num_mcode='".$arr[num_mcode]."' and dt_date>'$chkdate'";
	$arr['formcount'] = $DB->sqlFetchOne($sql);

	$arr['str_title'] = $arr['str_title']."(�ű�:".number_format($arr['formcount'])."��) ";
	$arr['link'] = "javascript:winOpen('/form.admin.list?mcode=".$arr['num_mcode']."',800,600,'yes')";
}



function list_format_media(&$arr) {
	global $DB,$_OID;
	/*if($arr['num_st'] == '0') $arr['num_st'] ="�Ա�Ȯ����";
	elseif($arr['num_st'] == '1') $arr['num_st'] ="�Ա�Ȯ��";
	elseif($arr['num_st'] == '2') $arr['num_st'] ="ī�����";
	elseif($arr['num_st'] == '3') $arr['num_st'] ="���";
	elseif($arr['num_st'] == '4') $arr['num_st'] ="����";
	*/
	//$arr['str_title'] = $arr['str_option']." / ".$arr['str_name']." / ".$num_st." / ".number_format($arr['num_price']);	//��ǰ,��û��,�ֹ�����,�����ݾ�

	$chkdate = mktime(0, 0, 0, date("m"), date("d")-3, date("Y"));
	if($arr['dt_date'] >$chkdate) {
		$arr['new2'] = "y";
	}
	if($arr[num_media_type] == "1") {
		$arr['link'] = "/lms.admin.order_m_view_off?num_order_number=".$arr['num_order_number'];		
	}else  {
	$arr['link'] = "/lms.admin.order_m_view?num_order_number=".$arr['num_order_number'];		
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
							ORDER BY num_serial desc 
							  )b
					   )a 
				 WHERE a.RNUM <= 5 ";
	}
	else if ( $set == 'book' ) {
		$sql = "
				SELECT a.* 
				FROM 
					(SELECT ROWNUM AS RNUM, 
							b.* 
						 FROM 
							(SELECT o.NUM_ORDER_NUMBER, 
									 o.NUM_SERIAL, 
									 o.NUM_CCODE, 
									 o.STR_ID, 
									 o.DT_DATE, 
									 o.NUM_ST, 
									 o.CHR_ZIP, 
									 o.STR_ADDR1, 
									 o.STR_ADDR2, 
									 o.NUM_BANK_NUMBER, 
									 o.STR_BANK_NAME, 
									 o.DT_BANK_DAY, 
									 o.NUM_VIEW_END, 
									 o.DT_START_DAY, 
									 o.STR_PHONE, 
									 o.STR_HANDPHONE, 
									 o.STR_MEMO, 
									 o.NUM_ORDER_PRICE, 
									 o.NUM_ORDER_SALE, 
									 o.NUM_ORDER_TYPE, 
									 o.NUM_MEDIA_TYPE, 
									 o.STR_TACH_CODE, 
									 o.STR_BOOK_CODE, 
									 o.NUM_BOOK_PRICE, 
									 o.NUM_ST_TAK, 
									 o.STR_OPTION, 
									 o.STR_PG_RETURN, 
									 o.NUM_POINT_USE, 
									 o.NUM_MCODE, 
									 o.STR_NAME, 
									 o.STR_SU_NUMBER, 
									 o.STR_OFF_ST, 
									 o.STR_TEXT, 
									 o.STR_RE_ORDER, 
									 o.NUM_OPTION_NUMBER,   
									 c.str_name AS str_bookname 
								FROM TAB_MEDIA_ORDER o, 
									 TAB_BOOK c 
							WHERE o.num_oid = $_OID 
									 AND o.num_media_type = 3 
									 AND o.STR_BOOK_CODE = c.STR_BOOK_CODE 
									 AND o.num_oid = c.num_oid 
							ORDER BY num_serial desc 
							)b 
					)a 
				WHERE a.RNUM <= 5 ";

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
							   and num_media_type == 1
							ORDER BY num_serial desc 
							  )b
					   )a 
				 WHERE a.RNUM <= 5 ";
	}

	return $sql;
}
?>
