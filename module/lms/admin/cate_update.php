<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2010-12-07
* 작성자: 김종태
* 설   명: 진열순서
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');


switch ($REQUEST_METHOD) {
	case "GET":
	
	//2010-12-08 종태 카테고리
	$sql = "select * from ".$table2." where num_oid = '$_OID' order by num_step";
	$cate_list = $DB -> sqlFetchAll($sql);
	$tpl->assign(array('cate_LIST'=>$cate_list));

	$tpl->setLayout('ajax');
	$tpl->define("CONTENT", Display::getTemplate("admin/lms/cate_update.htm"));
	
	 break;
	case "POST":
	 break;
	}

?>