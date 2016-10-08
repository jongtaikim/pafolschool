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
		$menu[$cate1]['str_title'] = "마이페이지";
		$menu[$cate1]['str_link'] = "member.mypage";

		$cate1 = 1;
		$menu[$cate1]['str_title'] = "회원정보변경";
		$menu[$cate1]['str_link'] = "member.modify";

		$cate1 = 2;
		$menu[$cate1]['str_title'] = "개인정보보호정책보기";
		$menu[$cate1]['str_link'] = "admin.pra_view?mode=pra&layout=sub";

		$cate1 = 3;
		$menu[$cate1]['str_title'] = "회원탈퇴하기";
		$menu[$cate1]['str_link'] = "member.del";

		}else{
		
		$cate1 = 0;
		$menu[$cate1]['str_title'] = "로그인";
		$menu[$cate1]['str_link'] = "member.login";

		$cate1 = 1;
		$menu[$cate1]['str_title'] = "아이디 비번 찾기";
		$menu[$cate1]['str_link'] = "member.findid";

		$cate1 = 2;
		$menu[$cate1]['str_title'] = "개인정보보호정책보기";
		$menu[$cate1]['str_link'] = "admin.pra_view?mode=pra&layout=sub";

		
		}
			
		return $menu;
		
		break;

}



?>