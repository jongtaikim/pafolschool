<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: module/lunch/__get.php
* �ۼ���: 2009-08-14
* �ۼ���: ������
* ��  ��: 
*****************************************************************
* 
*/
switch($param['key']) {
	case 'rights':
		return array('m'=>'����');
		break;
		case 'leftmenu':
		
		$menu = array();


		$menu[$cate1]['str_title'] = "�˾���";
		$menu[$cate1]['str_link'] = "popup.zone";




			
		return $menu;
		
		break;
}
?>