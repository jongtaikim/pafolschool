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


	
		$main_arr =  array(
			'menu_name'=>"����Ʈ��",
			'menu_url'=>array('act'=>'sitemap.view','mcode'=>$param['mcode']),
            'rights'=>array('l'=>'����Ʈ�ʺ���'),
            'default_rights'=>'l',
			'default_group_rights'=>'l',

		   
			'admin_desc'=>''
		);
		
		return  $main_arr;

		break;
   	case 'leftmenu':
		
		$menu = array();

		$cate1 = 0;
		$menu[$cate1]['str_title'] = "����Ʈ��";
		$menu[$cate1]['str_link'] = "sitemap.view";


			
		return $menu;
		break;
}
?>
