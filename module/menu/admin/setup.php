<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2008-09-02
* �ۼ���: ������
* ��  ��: �Ŵ�����
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');

switch ($REQUEST_METHOD) {
	case "GET":
	
	$tpl->setLayout('no');
	$tpl->define("CONTENT", Display::getTemplate("/menu/admin/setup.htm"));
	
	 break;
	case "POST":
	 break;
	}

?>