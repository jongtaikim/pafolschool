<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2010-07-02
* �ۼ���: ������
* ��   ��: ����Ʈ������ �ٵ�
*****************************************************************
* 
*/

	$tpl->assign(array('mcodes'=>$_SESSION[doc_mcode],'host'=>HOST,'theme'=>_THEME));
	$tpl->setLayout('blank');
	$tpl->define("CONTENT", Display::getTemplate("editbody.htm"));
	

?>