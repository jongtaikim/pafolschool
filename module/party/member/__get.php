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
		
		switch(_CAFETYPE) {
		case 'cafe':
			return array(
				'x' => "비회원",
				'w' => "인증대기",
				'v'=> "신입회원",
				'u' => "준회원",
				't' => "정회원",
				's'=> "우수회원",
				'b'=> "부매니저",
				'a'=> "매니저");
		break;
		case 'class':
			return array(
				'x' => "비회원",
				'w' => "인증대기",
				'v'=> "신입회원",
				'u' => "준회원",
				't' => "정회원",
				's'=> "우수회원",
				'b'=> "부운영자",
				'a'=> "담임선생님");
		break;
		case 'office':
			return array(
				'x' => "비회원",
				'w' => "인증대기",
				'v'=> "신입회원",
				'u' => "준회원",
				't' => "정회원",
				's'=> "우수회원",
				'b'=> "부매니저",
				'a'=> "매니저");
		break;
		}


	case 'menu':
		
		$typeArr = array('A'=>_('카페가입'));
		$typeArrUrl = array();
		$typeArrUrl['L'] = array('act'=>'party.member.join','pcode'=>$param['pcode']);
	
		$r_array =  array(
			'menu_name'=>$typeArr[$param['module_type']],
			'menu_url'=>$typeArrUrl[$param['module_type']],
/*
            'rights'=>array('r'=>'정보수정','l'=>'탈퇴'),
            'default_rights'=>'rl',
			'default_group_rights'=>'rl',
			'admin_desc'=>''
*/
		);

		return $r_array;
		break;
    case 'icon':
        return 'image/iicon/chart_bar.gif';

}



?>