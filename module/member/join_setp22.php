<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2008-01-30
* �ۼ���: ������
* ��  ��: �����Ӹ�~!
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');
	
	$tpl->setLayout('@sub');
	$tpl->define("CONTENT", Display::getTemplate("member/join_step.htm"));
	$tpl->assign(array(
		'return'=>"N",
		'str_id'=>$str_id,

		));
	
?>