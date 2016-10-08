<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2009-08-10
* 작성자: 김종태
* 설   명: 온라인 투표
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');


switch ($REQUEST_METHOD) {
	case "GET":
	
	$sql = "select * from TAB_VOTE where num_oid = $_OID order by dt_date asc ";
	$row = $DB -> sqlFetchAll($sql);
	$tpl->assign(array('LIST'=>$row));
	
	


	$tpl->setLayout('no3');
	$tpl->define("CONTENT", Display::getTemplate("vote/admin/main.htm"));
	
	 break;
	case "POST":
	 break;
	}

?>