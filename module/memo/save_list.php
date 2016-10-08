<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-11-24
* 설   명: 쪽지함보관함
*****************************************************************
* 
*/
function loginChk(){
if(!$_SESSION[USERID]) {
	echo '<script>alert("로그인이 필요합니다."); self.close();</script>';
	exit;
}
}


loginChk();
$tpl->define("MEMO_TOP", Display::getTemplate("memo/top.htm"));
	

$DB = &WebApp::singleton('DB');


switch ($REQUEST_METHOD) {
	case "GET":
	
	$tpl->setLayout('admin');
	$tpl->define("CONTENT", Display::getTemplate("memo/save_list.htm"));
	
	 break;
	case "POST":
	 break;
	}

?>