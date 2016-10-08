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
    case 'member_types':
	//학교사이트는 그룹명시못함. 관리자에서 차단.
	//$_member_type = WebApp::getConf('member_type');
	//abcdefghijklmnopqrstuvwx

		return array(
		'n' => '비회원',
		
		's' => '학생',
		'g' => '학부모',
	
		'm' => '맨토',
		'z' => '최고관리자' );
	


    case 'office_member_types':
		//온라인교무실 허가그룹
		return array(
		't' => '교직원',
		
		'd' => '중간관리자3', 
		'c' => '중간관리자2', 
		'b' => '중간관리자1', 
		'a' => '최고관리자' );

	case 'menu':
		
		$typeArr = array('L'=>_('로그인'),'F'=>_('ID/비밀번호찾기'),'J'=>_('회원가입'),'M'=>_('회원정보수정'),'D'=>_('탈퇴'),'A'=>_('개인정보보호정책'),'B'=>_('이용약관'));
		$typeArrUrl = array();
		$typeArrUrl['L'] = array('act'=>'member.login','mcode'=>$param['mcode']);
		$typeArrUrl['F'] = array('act'=>'member.findid','mcode'=>$param['mcode']);
		$typeArrUrl['J'] = array('act'=>'member.join','mcode'=>$param['mcode']);
		$typeArrUrl['M'] = array('act'=>'member.modify','mcode'=>$param['mcode']);
		$typeArrUrl['D'] = array('act'=>'member.del','mcode'=>$param['mcode']);
		$typeArrUrl['A'] = array('act'=>'member.chk1','mcode'=>$param['mcode']);
		$typeArrUrl['B'] = array('act'=>'member.chk2','mcode'=>$param['mcode']);
	
		$r_array =  array(
			'menu_name'=>$typeArr[$param['module_type']],
			'menu_url'=>$typeArrUrl[$param['module_type']],

            'rights'=>array('r'=>'정보수정','l'=>'탈퇴'),
            'default_rights'=>'rl',
			'default_group_rights'=>'rl',
			'admin_desc'=>''
		);
		
		return $r_array;
		break;


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
		$menu[$cate1]['str_title'] = "회원탈퇴하기";
		$menu[$cate1]['str_link'] = "member.del";

		}else{
		
		$cate1 = 0;
		$menu[$cate1]['str_title'] = "로그인";
		$menu[$cate1]['str_link'] = "javascript:login();";

		$cate1 = 1;
		$menu[$cate1]['str_title'] = "아이디 비번 찾기";
		$menu[$cate1]['str_link'] = "member.findid";

		$cate1 = 2;
		$menu[$cate1]['str_title'] = "개인정보보호정책보기";
		$menu[$cate1]['str_link'] = "admin.pra_view?mode=pra&layout=sub";

		
		}
			
		return $menu;
		
		break;
    case 'icon':
        return 'image/iicon/chart_bar.gif';

}



?>