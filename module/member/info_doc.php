<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2009-08-12
* �ۼ���: ������
* ��   ��: ȸ����å
*****************************************************************
* 
*/

switch ($REQUEST_METHOD) {
	case "GET":
	
	$tpl->setLayout('no3');
	$tpl->define("CONTENT", Display::getTemplate("member/info_doc.htm"));
	
	 break;
	case "POST":
	 break;
	}

?>