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
	
	$sql = "select * from TAB_TACH where num_oid = '$_OID' and num_serial = '$serial' ";
	$data = $DB -> sqlFetch($sql);
	$tpl->assign($data);

	$tpl->setLayout('admin');
	$tpl->define("CONTENT", Display::getTemplate("lms/tach_view.htm"));
	
	 break;
	case "POST":
	 break;
	}

?>