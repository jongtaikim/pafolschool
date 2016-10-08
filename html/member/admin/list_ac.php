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
	
	$sql = "select * from TAB_MEMBER where num_oid = '$_OID' ";
	$row = $DB -> sqlFetchAll($sql);
	$tpl->assign(array('LIST'=>$row));
	
	

	$tpl->setLayout('no4');
	$tpl->define("CONTENT", Display::getTemplate("member/admin/list_ac.htm"));
	
	 break;
	case "POST":
	$datas[str_plus1] = $str_plus1;
	$DB->updateQuery("TAB_MEMBER",$datas ," num_oid = '"._OID." and str_id = '".$str_id."' ");
	$DB->commit();		

	 break;
	}

?>