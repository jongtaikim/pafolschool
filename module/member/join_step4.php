<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2009-07-31
* �ۼ���: ������
* ��   ��: ���ԿϷ�!!
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');
	
	$DOC_TITLE = "str:ȸ�����ԿϷ�";

	$tpl->assign(array('name'=>$name,'str_id'=>$str_id));
	
	$tpl->setLayout('@sub');
	$tpl->define("CONTENT", Display::getTemplate("member/join_step4.htm"));
	

?>