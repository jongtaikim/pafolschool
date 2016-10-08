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
$table = "TAB_NEWS_MEMBER";

switch ($REQUEST_METHOD) {
	case "GET":
	
	if(!$types){
		$types = "1";
	}
	$code = $_REQUEST['code'];
	if(!$page = $_REQUEST['page']) $page = 1;

	if(!$listnum)$listnum = 15;
	$sql = "select count(*) from ".$table." where num_oid = '$_OID'  ";

	$total = $DB->sqlFetchOne($sql);

	if(!$total) $total = 0;


	$page = $_REQUEST['page'];
	if (!$page) $page = 1;

	$seek = $listnum * ($page - 1);
	$offset = $seek + $listnum;

	$sql = "
	select * from ".$table." where num_oid = '$_OID'   order by num_serial desc LIMIT $seek , $offset   ";

	//echo  $sql;

	$data = $DB->sqlFetchAll($sql);


	$tpl->assign(array(
	'title'=>$title,
	'LIST'=>$data,
	'page'=>$page,
	'total'=>$total,
	'listnum'=>$listnum
	));
	

	$tpl->setLayout('no3');
	$tpl->define("CONTENT", Display::getTemplate("news/admin/member_list.htm"));
	
	 break;
	case "POST":

		switch ($mode) {
		case "delete":
		
			
		for($ii=0; $ii<count($ids); $ii++) {
			$DB->deleteQuery("TAB_NEWS_MEMBER"," num_oid = '"._OID."' and num_serial = '".$ids[$ii]."' ");
			$DB->commit();
			//unlink(_DOC_ROOT."/hosts/".HOST."/lms/".$types."-".$ids[$ii].".*");
		}
			
			
		WebApp::moveBack('삭제되었습니다.');
		
		 break;
		 case "up_add":
		
			
		for($ii=0; $ii<count($ids); $ii++) {
			$datas[str_mailing] = 'y';
			$DB->updateQuery("TAB_NEWS_MEMBER",$datas," num_oid = '"._OID."' and num_serial = '".$ids[$ii]."' ");
			$DB->commit();

			
			//unlink(_DOC_ROOT."/hosts/".HOST."/lms/".$types."-".$ids[$ii].".*");
		}
			
			
		WebApp::moveBack('구독상태로 변경되었습니다.');
		
		 break;

		  case "up_cn":
		
			
		for($ii=0; $ii<count($ids); $ii++) {
			$datas[str_mailing] = 'n';
			$DB->updateQuery("TAB_NEWS_MEMBER",$datas," num_oid = '"._OID."' and num_serial = '".$ids[$ii]."' ");
			$DB->commit();

			
			//unlink(_DOC_ROOT."/hosts/".HOST."/lms/".$types."-".$ids[$ii].".*");
		}
			
			
		WebApp::moveBack('해지상태로 변경되었습니다.');
		
		 break;
		
		}



	 break;
	}

?>