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


	
		$main_arr =  array(
			'menu_name'=>"사이트맵",
			'menu_url'=>array('act'=>'sitemap.view','mcode'=>$param['mcode']),
            'rights'=>array('l'=>'사이트맵보기'),
            'default_rights'=>'l',
			'default_group_rights'=>'l',

		   
			'admin_desc'=>''
		);
		
		return  $main_arr;

		break;
   	case 'leftmenu':
		
		$menu = array();

		$cate1 = 0;
		$menu[$cate1]['str_title'] = "사이트맵";
		$menu[$cate1]['str_link'] = "sitemap.view";


			
		return $menu;
		break;
}
?>
