<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: __get.php
* 작성일: 
* 작성자: 김종캐
* 설  명: 
*****************************************************************
* 
*/
switch($param['key']) {
  
		case 'leftmenu':
		
		$menu = array();

		if($_SESSION[USERID]) {
			
		$cate1 = 0;
		$menu[$cate1]['str_title'] = "동아리 카페목록";
		$menu[$cate1]['str_link'] = "party.list";

		$cate1 = 1;
		$menu[$cate1]['str_title'] = "신규동아리 만들기";
		$menu[$cate1]['str_link'] = "party.cafe_add";





		}else{
		
		$cate1 = 0;
		$menu[$cate1]['str_title'] = "동아리 카페목록";
		$menu[$cate1]['str_link'] = "party.list";
		
		



			
		}
			
		return $menu;
		
		break;

}



?>