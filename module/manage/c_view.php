<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2008-03-25
* �ۼ���: ������
* ��  ��: ��Ų ��Ʈ������ ����Ʈ
*****************************************************************
* 
*/
$DB = &WebApp::singleton("DB");
switch ($REQUEST_METHOD) {
	case "GET":
	
$DOC_TITLE = "str:���ø� ������";

	$tpl->setLayout('@sub');
	$tpl->define("CONTENT", "/module/manage/c_view.htm");
	 break;
	case "POST":
	 break;
	}

?>