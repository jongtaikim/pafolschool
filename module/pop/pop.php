<?
/**
* ���ϸ�: module/pop/pop.php
* �ۼ���: 2007-07-03
* �ۼ���: ������
* ��  ��: �밡�ٸ� ������
*****************************************************************
* 
*/


$DOC_TITLE = 'str: �б��ѷ�����';


$tpl->setLayout('@sub');
$tpl->define('CONTENT',Display::getTemplate('pop/pop.html'));




$tpl->assign(array(
			'img' => $img,
			'dir' => $dir,
			'title_text' => "����",	
					));





						
?>