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
	
	
	$sql = "select str_plus1 , count(str_plus1) as counter from TAB_MEMBER  where num_oid = '$_OID' group by str_plus1 ";
	$row = $DB -> sqlFetchAll($sql);

	$tpl->assign(array('total_LIST'=>$row));
	
	


	if(!$page = $_REQUEST['page']) $page = 1;
	
	if(!$listnum)$listnum = 30;
	$sql = "SELECT COUNT(*) FROM ".TAB_MEMBER." WHERE NUM_OID=$_OID ";
	$total = $DB->sqlFetchOne($sql);
	if(!$total) $total = 0;
	
	
	$page = $_REQUEST['page'];
	if (!$page) $page = 1;
	
	$seek = $listnum * ($page - 1);
	$offset = $seek + $listnum;

	
	$sql = "
	select * from TAB_MEMBER where num_oid = '$_OID' order by dt_date desc   limit $seek ,$listnum ";
	
	
	
	
	$data = $DB->sqlFetchAll($sql);

	$tpl->assign(array(
	'title'=>$title,
	'LIST'=>$data,
	'page'=>$page,
	'total'=>$total,
	'listnum'=>$listnum
	));
	
	


	$tpl->setLayout('no4');
	$tpl->define("CONTENT", Display::getTemplate("member/admin/list_ac.htm"));
	
	 break;
	case "POST":
	$datas[str_plus1] = iconv("utf-8","euc-kr",$str_plus1);
	$datas[str_plus2] = iconv("utf-8","euc-kr",$str_plus2);
	//$sqlV = 'y';
	$DB->updateQuery("TAB_MEMBER",$datas ," num_oid = '"._OID."' and str_id = '".$str_id."' ");
	$DB->commit();		

	 break;
	}

?>