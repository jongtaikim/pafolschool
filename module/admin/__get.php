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
		$menu[$cate1]['str_title'] = "����������";
		$menu[$cate1]['str_link'] = "member.mypage";

		$cate1 = 1;
		$menu[$cate1]['str_title'] = "ȸ����������";
		$menu[$cate1]['str_link'] = "member.modify";

		$cate1 = 2;
		$menu[$cate1]['str_title'] = "����������ȣ��å����";
		$menu[$cate1]['str_link'] = "admin.pra_view?mode=pra&layout=sub";

		$cate1 = 3;
		$menu[$cate1]['str_title'] = "ȸ��Ż���ϱ�";
		$menu[$cate1]['str_link'] = "member.del";

		}else{
		
		$cate1 = 0;
		$menu[$cate1]['str_title'] = "�α���";
		$menu[$cate1]['str_link'] = "member.login";

		$cate1 = 1;
		$menu[$cate1]['str_title'] = "���̵� ��� ã��";
		$menu[$cate1]['str_link'] = "member.findid";

		$cate1 = 2;
		$menu[$cate1]['str_title'] = "����������ȣ��å����";
		$menu[$cate1]['str_link'] = "admin.pra_view?mode=pra&layout=sub";

		
		}
			
		return $menu;
		
		break;

}



?>