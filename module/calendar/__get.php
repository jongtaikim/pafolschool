<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2009-07-31
* 작성자: 김종태
* 설  명: 
*****************************************************************
* 
*/
switch($param['key']) {
	case 'rights':
		return array('m'=>'관리');
		break;
		case 'leftmenu':
		
		$menu = array();

		$menu[$cate1]['str_title'] = "학사일정";
		$menu[$cate1]['str_link'] = "calendar.list";

	


			
		return $menu;
		
		break;
}
?>