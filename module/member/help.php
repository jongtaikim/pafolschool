<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2008-01-30
* �ۼ���: ������
* ��  ��: �����Ӹ�~!
*****************************************************************
* 
*/

$tpl->setLayout('admin_xhtml');

switch ($mode) {
	case "1":

	$tpl->define("CONTENT", Display::getTemplate("member/joinHelpPage.html"));
	
	 break;
	case "2":
	 break;
	}

?>