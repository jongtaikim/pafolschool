<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: module/admin/top.php
* �ۼ���: 2005-05-25
* �ۼ���: ��ģ����
* ��  ��: �����ڸ�� ��� ���
*****************************************************************
* 
*/
$tpl->setLayout('admin');
$tpl->assign(array('mode'=>$mode));
$tpl->define('CONTENT', Display::getTemplate('top_c.htm'));
?>
