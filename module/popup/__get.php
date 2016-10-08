<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/lunch/__get.php
* 작성일: 2009-08-14
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


		$menu[$cate1]['str_title'] = "팝업존";
		$menu[$cate1]['str_link'] = "popup.zone";




			
		return $menu;
		
		break;
}
?>