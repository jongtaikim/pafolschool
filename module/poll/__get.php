<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: __get.php
* �ۼ���: 2008-10-18 
* �ۼ���: ������
* ��  ��: 
*****************************************************************
* 
*/

switch($param['key']) {
	case 'menu':
	
		$typeArr = array('B'=>_('����������'),'A'=>_('�¶�����ǥ'));
		

		$typeArrUrl = array();
		$typeArrUrl['B'] = array('act'=>'poll.list','mcode'=>$param['mcode'],'type'=>'poll');
		$typeArrUrl['A'] = array('act'=>'poll.list','mcode'=>$param['mcode'],'type'=>'vote');
		

		$main_arr =  array(
				'menu_name'=>$typeArr[$param['module_type']],
			'menu_url'=>$typeArrUrl[$param['module_type']],
            'rights'=>array('l'=>'��Ϻ���'),
            'default_rights'=>'l',
			'default_group_rights'=>'l',

		   
			'admin_desc'=>''
		);
		
		return  $main_arr;

		break;
		case 'leftmenu':
		
		$menu = array();

		$menu[$cate1]['str_title'] = "�¶��μ�������";
		$menu[$cate1]['str_link'] = "/poll.list";

	


			
		return $menu;
		
		break;
    case 'icon':
	 return 'image/icon/chm.gif';
	break;
}
?>
