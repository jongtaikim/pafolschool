<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: 
* �ۼ���: 
* �ۼ���: �̹���
* ��  ��: 
*****************************************************************
* 
*/
 $tpl->setLayout('no2');
$tpl->assign(array('mcode'=>$mcode));
	
	
$tpl->define('CONTENT',WebApp::getTemplate('menu/admin/frame.htm'));
?>