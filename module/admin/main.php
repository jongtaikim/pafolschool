<?
//2008-01-04 ����
/**********************************
���ο� �б� ������

���α׷� : ���� 

**********************************/


//�б޼��� üũ
$DB = &WebApp::singleton('DB');
//$DB->backup_mysql(date("Ymd"));

/*$sql = "select count(*) from TAB_CLASS_GRADE where num_oid = $_OID ";
$class_row = $DB -> sqlFetchOne($sql);

/*
if(!$class_row && _AOID != _OID && !$class) {
WebApp::confirm('"�б����� �����ϴ�. �б��� ���Ͻðڽ��ϱ�?"','/admin.form.main?PageNum=020200','/admin.main?class=no');

}*/



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





//2008-10-28  ���� ȸ������ �����ڿ� ǥ��
$_member_type = WebApp::getConf('member_type');
$tpl->assign(array('gname'=>$_member_type[$_SESSION['CHR_MTYPE']]));

$sql = "select num_disk,num_upload_size,str_end_date from TAB_ORGAN where num_oid = $_OID ";

//$disk_db = $DB -> sqlFetch($sql);
$disk_db[num_disk] = byte_convert($disk_db[num_disk]);
$disk_db[num_upload_size] = byte_convert($disk_db[num_upload_size]);
$tpl->assign($disk_db);






	
	$DB = &WebApp::singleton('DB');
	$sql = "select

	   str_organ, str_title, 
	   str_host, str_domain, str_theme, 
	   TO_CHAR(dt_date,'YYYY-MM-DD')  as dt_date

	from TAB_ORGAN where num_oid = $_OID ";
	$data_organ = $DB -> sqlFetch($sql);
	$tpl->assign($data_organ);
	
	$sql = "select count(*) from TAB_MEMBER where num_oid = $_OID ";
	$member_total = $DB -> sqlFetchOne($sql);
	$tpl->assign(array('member_total'=>$member_total));
	
	$sql = "select count(*) from TAB_MEMBER where num_oid = $_OID and num_auth = 0";
	$member_total_m = $DB -> sqlFetchOne($sql);
	$tpl->assign(array('member_total_m'=>$member_total_m));

	


	

	$sql = "

	select a.* from (
    select ROWNUM as RNUM, b.* from (

SELECT /*+ INDEX_DESC (A $ARTICLE_ALL_INDEX) */
        A.num_mcode,
        A.num_depth,
        A.num_serial,
        A.str_title,
        A.str_name,
        A.str_thumb,
		A.num_input_pass,
		A.num_comment,

		A.str_ip,
         TO_CHAR(A.dt_date,'YYYY-MM-DD') dt_date
		  
		  FROM TAB_BOARD_CONFIG B, TAB_BOARD A WHERE
		
		B.num_oid="._OID." AND
        A.num_oid="._OID." AND ".

"       A.dt_date <= SYSDATE and
        A.num_mcode=B.num_mcode 
		and B.chr_listtype != 'D' 
		
    ORDER BY A.dt_date DESC

)b)a

 where a.RNUM >= 0 and a.RNUM <=5

";


	// ���⼭ 5�� �Խù���. Ÿ�ٺ��� �ٸ��ٸ� �������Ͽ� �߰��ؾ� �Ѵ�.
	$data = $DB->sqlFetchAll($sql);




for($ii=0; $ii<count($data); $ii++) {
	$data[$ii]['link'] = 'board.read?mcode='.$data[$ii]['num_mcode'].'&id='.$data[$ii]['num_serial'];

	$data[$ii]['str_title'] = Display::text_cut($data[$ii]['str_title'],40,"..");		
	if ($data[$ii]['num_depth']) $data[$ii]['str_title'] = 'Re: '.$data[$ii]['str_title'];
	$a = explode("-",$data[$ii]['dt_date']);
	$data[$ii]['dt_date1']= $a[0];
	$data[$ii]['dt_date2']= $a[1];
	$data[$ii]['dt_date3']= $a[2];
	$data[$ii]['is_recent'] = date('U') - strtotime($data[$ii]['dt_date']) < 241920;
	}

	$tpl->assign(array('bbs_LIST'=>$data));


/*define('_AOIDNEWS', 1310); //��Ʈ��� ��������
define('_AOIDAS1', 1510); //��Ʈ��� �۾���û�Խ���
define('_AOIDAS2', 1512); //��Ʈ��� ���ǰԽ���
*/





	$sql = "

	select a.* from (
    select ROWNUM as RNUM, b.* from (

SELECT /*+ INDEX_DESC (A $ARTICLE_ALL_INDEX) */
        A.num_mcode,
        A.num_depth,
        A.num_serial,
        A.str_title,
        A.str_name,
        A.str_thumb,
		A.str_category,
		A.num_input_pass,
		A.num_comment,

         TO_CHAR(A.dt_date,'YYYY-MM-DD') dt_date
		  
		  FROM TAB_BOARD_CONFIG B, TAB_BOARD A WHERE
		
		B.num_oid="._AOID." AND
        A.num_oid="._AOID." AND ".

" 
        A.num_mcode=B.num_mcode and
		A.num_mcode="._AOIDAS2." 
		and B.chr_listtype != 'D' 
		
    ORDER BY A.dt_date DESC

)b)a

 where a.RNUM >= 0 and a.RNUM <=4

";
	// ���⼭ 5�� �Խù���. Ÿ�ٺ��� �ٸ��ٸ� �������Ͽ� �߰��ؾ� �Ѵ�.
$data = $DB->sqlFetchAll($sql);

for($ii=0; $ii<count($data); $ii++) {
	

	$data[$ii]['link'] = 'tong_board.read?mcode='.$data[$ii]['num_mcode'].'&id='.$data[$ii]['num_serial'];
	$data[$ii]['str_title'] = Display::text_cut($data[$ii]['str_title'],40,"..");		
	if ($data[$ii]['num_depth']) $data[$ii]['str_title'] = 'Re: '.$data[$ii]['str_title'];
	$a = explode("-",$data[$ii]['dt_date']);
	$data[$ii]['dt_date1']= $a[0];
	$data[$ii]['dt_date2']= $a[1];
	$data[$ii]['dt_date3']= $a[2];
	$data[$ii]['is_recent'] = date('U') - strtotime($data[$ii]['dt_date']) < 241920;
}

$tpl->assign(array('bbs_LIST2'=>$data));





	

	$sql = "

	select a.* from (
    select ROWNUM as RNUM, b.* from (

SELECT /*+ INDEX_DESC (A $ARTICLE_ALL_INDEX) */
        A.num_mcode,
        A.num_depth,
        A.num_serial,
        A.str_title,
        A.str_name,
        A.str_thumb,
		A.num_input_pass,
		A.num_comment,
		A.str_category,

         TO_CHAR(A.dt_date,'YYYY-MM-DD') dt_date
		  
		  FROM TAB_BOARD_CONFIG B, TAB_BOARD A WHERE
		
		B.num_oid="._AOID." AND
        A.num_oid="._AOID." AND ".

" 
        A.num_mcode=B.num_mcode and
		A.num_mcode="._AOIDNEWS." 
		and B.chr_listtype != 'D' 
		
    ORDER BY A.dt_date DESC

)b)a

 where a.RNUM >= 0 and a.RNUM <=5

";
	// ���⼭ 5�� �Խù���. Ÿ�ٺ��� �ٸ��ٸ� �������Ͽ� �߰��ؾ� �Ѵ�.
$data = $DB->sqlFetchAll($sql);

for($ii=0; $ii<count($data); $ii++) {
	

	$data[$ii]['link'] = 'tong_board.read?mcode='.$data[$ii]['num_mcode'].'&id='.$data[$ii]['num_serial'];
	$data[$ii]['str_title'] = Display::text_cut($data[$ii]['str_title'],36,"..");		
	if ($data[$ii]['num_depth']) $data[$ii]['str_title'] = 'Re: '.$data[$ii]['str_title'];
	$a = explode("-",$data[$ii]['dt_date']);
	$data[$ii]['dt_date1']= $a[0];
	$data[$ii]['dt_date2']= $a[1];
	$data[$ii]['dt_date3']= $a[2];
	$data[$ii]['is_recent'] = date('U') - strtotime($data[$ii]['dt_date']) < 241920;
}

$tpl->assign(array('bbs_LIST3'=>$data));





	$tpl->setLayout('admin_main'); // ���̾ƿ��� ����


		$tpl->define("CONTENT", WebApp::getTemplate("admin/main2.htm"));


	$tpl->assign(array(
		'organ'=>$organ,
		
		
	));





?>
