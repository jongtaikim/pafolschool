<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-11-18
* 작성자: 김종태
* 설   명: 개인정보보호정책
*****************************************************************
* 
*/

switch ($REQUEST_METHOD) {
	case "GET":

WebApp::goMcode ("member#A");
	
	$sql = "select str_title from TAB_MENU where num_oid = $_OID and num_mcode = $mcode  ";
	$menu_name = $DB -> sqlFetchOne($sql);
	if($menu_name) {
	$DOC_TITLE = "str:".$menu_name;
	}else{
	$DOC_TITLE = "str:개인정보보호정책";
	}
		

	$content1 = file_get_contents(_DOC_ROOT.'/hosts/'.HOST.'/conf/member1.conf.php');
	$content2 = file_get_contents(_DOC_ROOT.'/hosts/'.HOST.'/conf/member2.conf.php');
	$content3 = file_get_contents(_DOC_ROOT.'/hosts/'.HOST.'/conf/member3.conf.php');
	$content4 = file_get_contents(_DOC_ROOT.'/hosts/'.HOST.'/conf/member4.conf.php');
	

	$tpl->assign($_MEMBER);
	$tpl->assign(array('content1'=>$content1,'content2'=>$content2,'content3'=>$content3,'content4'=>$content4));

	$tpl->setLayout();
	$tpl->define("CONTENT", Display::getTemplate("member/chk1.htm"));
	

	$sql = "select * from TAB_ORGAN where num_oid = $_OID ";
	$data = $DB -> sqlFetch($sql);
	$tpl->assign($data);



	 break;
	
	}

?>