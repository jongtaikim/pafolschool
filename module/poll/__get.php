<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: __get.php
* 작성일: 2008-10-18 
* 작성자: 김종태
* 설  명: 
*****************************************************************
* 
*/

switch($param['key']) {
	case 'menu':
	
		$typeArr = array('B'=>_('설문조사목록'),'A'=>_('온라인투표'));
		

		$typeArrUrl = array();
		$typeArrUrl['B'] = array('act'=>'poll.list','mcode'=>$param['mcode'],'type'=>'poll');
		$typeArrUrl['A'] = array('act'=>'poll.list','mcode'=>$param['mcode'],'type'=>'vote');
		

		$main_arr =  array(
				'menu_name'=>$typeArr[$param['module_type']],
			'menu_url'=>$typeArrUrl[$param['module_type']],
            'rights'=>array('l'=>'목록보기'),
            'default_rights'=>'l',
			'default_group_rights'=>'l',

		   
			'admin_desc'=>''
		);
		
		return  $main_arr;

		break;
		case 'leftmenu':
		
		$menu = array();

		$menu[$cate1]['str_title'] = "온라인설문조사";
		$menu[$cate1]['str_link'] = "/poll.list";

	


			
		return $menu;
		
		break;
    case 'icon':
	 return 'image/icon/chm.gif';
	break;
}
?>
