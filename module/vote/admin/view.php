<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2009-08-10
* 작성자: 김종태
* 설   명: 결과보기
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
	
	$sql = "select count(*) from TAB_VOTE_DATA where num_oid = $_OID and num_serial = $serial ";
	$data[total_data] = $DB -> sqlFetchOne($sql);

	$sql = "select count(*) as counter , b.str_name ,a.num_chk from TAB_VOTE_DATA a, TAB_VOTE_USER b 
	where 
	a.num_oid = $_OID and 
	a.num_serial = $serial  and 
	a.num_oid = b.num_oid 	and 
	a.num_serial = b.num_serial  and
	a.num_chk = b.num_user_number

	
	group by str_name, num_chk 
	order by counter desc
	";
	


	$row = $DB -> sqlFetchAll($sql);
	$tpl->assign(array('LIST'=>$row));
	
	
	

	$tpl->assign($data);
	}
	

	$tpl->setLayout('no3');
	$tpl->define("CONTENT", Display::getTemplate("vote/admin/view.htm"));
	
	 break;
	case "POST":
	 break;
	}

?>