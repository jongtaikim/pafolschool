<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: __get.php
* �ۼ���: 
* �ۼ���: ����ĳ
* ��  ��: 
*****************************************************************
* 
*/
switch($param['key']) {
  
		case 'leftmenu':
		
		$menu = array();

		if($_SESSION[USERID]) {
			
		$cate1 = 0;
		$menu[$cate1]['str_title'] = "���Ƹ� ī����";
		$menu[$cate1]['str_link'] = "party.list";

		$cate1 = 1;
		$menu[$cate1]['str_title'] = "�űԵ��Ƹ� �����";
		$menu[$cate1]['str_link'] = "party.cafe_add";





		}else{
		
		$cate1 = 0;
		$menu[$cate1]['str_title'] = "���Ƹ� ī����";
		$menu[$cate1]['str_link'] = "party.list";
		
		



			
		}
			
		return $menu;
		
		break;

}



?>