<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2011-09-02
* 작성자: 김종태
* 설   명: q&a
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');


switch ($REQUEST_METHOD) {
	case "GET":
	

	$code = $_REQUEST['code'];
	if(!$page = $_REQUEST['page']) $page = 1;

	if(!$listnum)$listnum = 15;
	$sql = "select count(*) from TAB_QNA where num_oid = '$_OID' and num_mcode = '".$mcode."'  and str_wr_index = 1 ";
	$total = $DB->sqlFetchOne($sql);
	if(!$total) $total = 0;


	$page = $_REQUEST['page'];
	if (!$page) $page = 1;

	$seek = $listnum * ($page - 1);
	$offset = $seek + $listnum;

	$sql = "
	select * from TAB_QNA where num_oid = '$_OID' and num_mcode = '".$mcode."' and str_wr_index = 1  order by num_group desc LIMIT $seek , $listnum   ";

	//echo  $sql;

	$data = $DB->sqlFetchAll($sql);
	
	for($ii=0; $ii<count($data); $ii++) {
		$data[$ii]['num'] = $total - $seek - $ii;
	}
	

	$tpl->assign(array(
	'title'=>$title,
	'LIST'=>$data,
	'page'=>$page,
	'total'=>$total,
	'listnum'=>$listnum
	));
	

	


	$tpl->setLayout('@sub');
	$tpl->define("CONTENT", Display::getTemplate("qna/list.htm"));
	
	 break;
	case "POST":
	 break;
	}

?>