<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2008-01-30
* �ۼ���: ������
* ��  ��: �����Ӹ�~!
*****************************************************************
* 
*/


$tpl->setLayout('admin');
$tpl->define("CONTENT",WebApp::getTemplate("popup/skin/".$skin."/view.htm"));
$tpl->assign(array(
	'content'=>$contentpv,
	'str_title'=>$title,
	'num_width'=>$width,
	'num_height'=>$height,
	));


?>