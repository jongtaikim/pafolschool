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
	
	

	
	if($ccode){
		$where = " and num_ccode = '".$ccode."' ";
	}

	if(!$listnum)$listnum = 40;
	if(!$page)$page = 1;
	$sql = "SELECT COUNT(*) FROM ".TAB_TACH." WHERE NUM_OID=$_OID $where ";
	
	
	$total = $DB->sqlFetchOne($sql);
	if(!$total) $total = 0;
	
	
	$page = $_REQUEST['page'];
	if (!$page) $page = 1;
	
	$seek = $listnum * ($page - 1);
	$offset = $seek + $listnum;
	
	
	$sql = "select * from TAB_TACH where num_oid = '$_OID' $where order by num_serial desc limit $seek , $listnum ";
	$row = $DB -> sqlFetchAll($sql);
	$tpl->assign(array(
	 'total'=>$total,
	 'listnum'=>$listnum,
	 'LIST'=>$row,
	 ));

	$tpl->setLayout('@sub');
	$tpl->define("CONTENT", Display::getTemplate("lms/tach_main.htm"));
	
	 break;
	case "POST":
	 break;
	}

?>