<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2008-01-30
* �ۼ���: ������
* ��  ��: ����Ʈ ��û
*****************************************************************
* 
*/
$DB = &WebApp::singleton("DB");
switch ($REQUEST_METHOD) {
	case "GET":
	$DOC_TITLE = "str:ȸ������ ����";

	$tpl->setLayout('@sub');
	$tpl->define("CONTENT", Display::getTemplate("member/jinsung_type.htm"));
	
	 break;
	}

?>
