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
 $tpl->setLayout('admin');


		
$tpl->define('CONTENT',WebApp::getTemplate('menu/admin/frame_no.htm'));

$tpl->assign(array('mcode'=>$mcode,'f' => $f));


?>