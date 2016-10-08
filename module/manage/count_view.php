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
	
	$sql = "select * from TAB_IP_COUNTER a, TAB_ORGAN b where a.num_oid = b.num_oid  and ROWNUM <= 100 order by num_date desc ";
	
	$row = $DB -> sqlFetchAll($sql);
	$tpl->assign(array('LIST'=>$row));
	
	

	$tpl->setLayout('admin');
	$tpl->define("CONTENT", Display::getTemplate("manage/count_view.htm"));
	
	 break;
	case "POST":
	 break;
	}

?>