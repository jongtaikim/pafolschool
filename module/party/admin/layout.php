<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2009-07-20
* �ۼ���: ������
* ��   ��: ī�� ���̾ƿ�����
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');


switch ($REQUEST_METHOD) {
	case "GET":
	
	$tpl->setLayout('admin');
	$tpl->define("CONTENT", Display::getTemplate("party/admin/layout.htm"));
	
	 break;
	case "POST":
	 break;
	}

?>