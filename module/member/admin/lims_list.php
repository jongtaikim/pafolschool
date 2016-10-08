<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: list.php
* 작성일: 2006-03-17
* 작성자: 이범민
* 설  명: 회원목록
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');


function mkday($date){
$a = explode("-",$date);
$mkt = mktime(00, 00, 01, $a[1],  $a[2], $a[0]);
return $mkt;
}


switch($REQUEST_METHOD) {
	case "GET":

        $search_key = $_REQUEST['search_key'];
        $search_value = $_REQUEST['search_value'];
        if(isset($search_key) && isset($search_value)) {
            if(substr($search_key,0,3) != "num") {
                $where = "AND $search_key LIKE '%$search_value%' ";
            } else {
                $where = "AND $search_key = $search_value ";
            }
        }
		if($search_ccode) $where .= " and c.num_ccode=$search_ccode";
		if($str_option) $where .= " and a.str_option = '".$str_option."'";

		if(!$page = $_REQUEST['page']) $page = 1;

		if(!$listnum)$listnum = 10;



		 if(isset($start_day) && isset($end_day)) {
                $where .= "AND a.dt_date between '".mkday($start_day)."' and '".mkday($end_day)."' ";

        }

		$sql = "SELECT COUNT(*) FROM TAB_MEDIA_ORDER a, TAB_MEMBER b , TAB_MEDIA_CONFIG c
		 where 
		 a.num_oid = '$_OID' and
		 a.num_oid = b.num_oid and
		 a.num_oid = c.num_oid and

		 a.num_ccode = c.num_ccode and
		 a.str_id = b.str_id and  c.num_media_type != '1'
		 
		 $where

		 ";




		$total = $DB->sqlFetchOne($sql);
		if(!$total) $total = 0;


		$page = $_REQUEST['page'];
		if (!$page) $page = 1;

		$seek = $listnum * ($page - 1);
		$offset = $seek + $listnum;
		
		$fno = $total-($listnum * ($page-1));

		switch($align) {
			case "name":
			$align = " order by b.str_name ";
			break;
			case "id":
			$align = " order by b.str_id ";
			break;
			case "mtype":
			$align = " order by b.chr_mtype ";
			break;
			case "str_nick":
			$align = " order by b.str_nick ";
			break;
			default:
			$align = " order by a.num_serial desc ";
			break;
		}

		$sql = "
		select a.* from (
				 select ROWNUM as RNUM, b.* from (

		select 

		   a.NUM_OID, 
		   a.NUM_ORDER_NUMBER, 
		   a.NUM_SERIAL, 
		   a.NUM_CCODE, 
		   a.STR_ID, 
		   a.DT_DATE, 
		   a.NUM_ST,
		   a.NUM_VIEW_END,
		   a.NUM_ORDER_PRICE AS NUM_PRICE,
		   a.STR_BOOK_CODE,
		   a.STR_BANK_NAME,
		   a.NUM_BANK_NUMBER,
		   a.NUM_ORDER_SALE,
		   a.NUM_ST_TAK,
		   a.STR_OPTION,
		   a.DT_START_DAY,

 
			b.STR_NAME,
			b.CHR_MTYPE,
			b.STR_PASSWD,
			b.STR_NICK,
			b.NUM_AUTH,
			b.STR_STATE,
			b.NUM_GRADE,


		   c.STR_TITLE, 
		   c.STR_TITLE2

		   
		 
		 from TAB_MEDIA_ORDER a, TAB_MEMBER b , TAB_MEDIA_CONFIG c
		 where 
		 a.num_oid = '$_OID' and
		 a.num_oid = b.num_oid and
		 a.num_oid = c.num_oid and

		 a.num_ccode = c.num_ccode and
		 a.str_id = b.str_id and
		 c.num_media_type != '1'

		 $where

		 $align
		)b)a
						where a.RNUM >=  $seek and a.RNUM <= $offset ";




		$data = $DB -> sqlFetchAll($sql);

		// 2008-11-18 현민 상품리스트 더 세분화해서 표시되는걸로 변경
		//$sql = "SELECT num_ccode, str_title FROM TAB_MEDIA_CONFIG where NUM_OID=$_OID AND num_media_type = '2'";
		//$data2 = $DB -> sqlFetchAll($sql);

		$sql = "select distinct str_option  from TAB_MEDIA_ORDER where num_oid = $_OID ";
		$data2 = $DB -> sqlFetchAll($sql);

		$tpl->define("CONTENT", Display::getTemplate("lms/admin/order_m_list.htm"));
		$tpl->assign(array(
		'title'=>$title,
		'LIST'=>$data,
		'LIST2'=>$data2,
		'page'=>$page,
		'total'=>$total,
		'listnum'=>$listnum,
		'itemPerPage'=>$itemPerPage,
		'fno'=>$fno
		));

		$tpl->assign(array(
			'ccode'=>$ccode,
			'search_key'	=>	$search_key,
			'search_value'	=>	$search_value,
			'search_ccode'	=>	$search_ccode,
			));


if(!$start_day) {
$start_day = date("Y-m-d",mktime()-(86400*30));
}

if(!$end_day) {
$end_day = date("Y-m-d");
}

$tpl->assign(array(
	'start_day'=>$start_day,
	'end_day'=>$end_day,
	));


		$tpl->define('CONTENT','html/member/admin/lims_list.htm');

	break;
	case "POST":


        switch($_POST['mode']) {
        	case "delete":

				for($a=0 ; $a<sizeof($ids) ; $a++){
					if($ids[$a]){
						$sql = "delete from TAB_MEDIA_ORDER where num_oid=$_OID and str_id='$ids[$a]' and num_serial=$ids_s[$a] and num_order_number=$ids_o[$a]";
						$DB->query($sql);
						$DB->commit();
						//echo $sql."<br>";
					}
				}

				WebApp::moveBack('삭제되었습니다.');

        	break;

        }

	break;
}
?>
