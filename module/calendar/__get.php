<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2009-07-31
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

		$menu[$cate1]['str_title'] = "�л�����";
		$menu[$cate1]['str_link'] = "calendar.list";

	


			
		return $menu;
		
		break;
}
?>