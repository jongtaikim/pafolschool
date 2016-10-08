<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2011-08-23
* 작성자: 김종태
* 설   명: 용어사전
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');


switch ($REQUEST_METHOD) {
	case "GET":
	

	if($word){
		$psql = " and str_index = '".$word."'  ";
	}

	if($keyword){
		$psql = " and str_word like '%".$keyword."%'  ";
	}


	if(!$page = $_REQUEST['page']) $page = 1;
	
	if(!$listnum)$listnum = 30;
	$sql = "SELECT COUNT(*) FROM ".TAB_TEXT_DB." WHERE NUM_OID=$_OID and num_mcode='$mcode' $psql";

	$total = $DB->sqlFetchOne($sql);
	if(!$total) $total = 0;

	
	
	$seek = $listnum * ($page - 1);
	$offset = $seek + $listnum;
	
	$sql = "
	select * from ".TAB_TEXT_DB." where num_oid = '$_OID' and num_mcode='$mcode'  $psql  order by num_date desc LIMIT $seek , $listnum   ";
	
	//echo  $sql;
	
	
	$data = $DB->sqlFetchAll($sql);
	
	$tpl->assign(array(
	'LIST'=>$data,
	'page'=>$page,
	'total'=>$total,
	'listnum'=>$listnum,

	));


	$tpl->setLayout('@sub');
	$tpl->define("CONTENT", Display::getTemplate("text_db/list.htm"));
	
	 break;
	case "POST":
	 break;
	}

?>