<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2009-01-15
* 작성자: 
* 설   명: 
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');

switch ($REQUEST_METHOD) {
	case "GET":
	
	$sql = "select * from TAB_PROJECT where num_mcode = ".$mcode."";

	$pro_data = $DB -> sqlFetch($sql);
	$tpl->assign($pro_data);
	
	$sql = "select count(*) from TAB_BOARD where num_oid = $_OID and num_mcode in ('".$pro_data[num_board_mcode1]."','".$pro_data[num_board_mcode2]."','".$pro_data[num_board_mcode3]."','".$pro_data[num_board_mcode4]."')";
	$cou = $DB -> sqlFetchOne($sql);


	$tpl->assign(array('pro_count'=>$cou));
	
	


	$tpl->assign(array('mcode'=>$mcode));


	$tpl->setLayout();
	$tpl->define("CONTENT", Display::getTemplate("manage/mk_module.htm"));
	
	 break;
	case "POST":
	 break;
	}

?>