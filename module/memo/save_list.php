<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2008-11-24
* ��   ��: �����Ժ�����
*****************************************************************
* 
*/
function loginChk(){
if(!$_SESSION[USERID]) {
	echo '<script>alert("�α����� �ʿ��մϴ�."); self.close();</script>';
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