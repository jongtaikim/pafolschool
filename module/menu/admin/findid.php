<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2009-07-13
* 작성자: 김종태
* 설   명: 회원을 검색해 아이디를 리턴함
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');


switch ($REQUEST_METHOD) {
	case "GET":
	
	if($name){
	$sql = "select str_name,str_id from TAB_MEMBER where num_oid = $_OID and str_name like '%$name%' ";
	$row = $DB -> sqlFetchAll($sql);
	$tpl->assign(array('LIST'=>$row,'name'=>$name));
	
	
	}
	
	$tpl->setLayout('admin');
	$tpl->define("CONTENT", Display::getTemplate("menu/admin/findid.htm"));
	
	 break;
	case "POST":
	 break;
	}

?>