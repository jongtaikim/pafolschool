<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2008-01-30
* �ۼ���: ������
* ��  ��: �����Ӹ�~!
*****************************************************************
* 
*/

//����� �ƴҰ��� ���켼��

switch ($REQUEST_METHOD) {
	case "GET":
	
	$tpl->setLayout('admin');
	$tpl->assign(array('text'=>"���̾ƿ��� ����Ǿ����ϴ�. �����۾��� �����ϼ���."));
	
	
	$tpl->define("CONTENT", Display::getTemplate("attach/admin/select.htm"));
	
	 break;
	}

?>