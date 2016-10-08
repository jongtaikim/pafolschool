<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/member/join.php
* 작성일: 2008-01-21
* 작성자: 김종태
* 설  명: 회원가입
*****************************************************************
* 
*/

switch (REQUEST_METHOD) {
	case 'GET':


	$tpl->assign(array(
	 'num_birthday'=>$num_birthday,
	 'chr_mtype'=>$chr_mtype,
	 'str_name'=>$str_name,
	 'chr_birthday'=>$chr_birthday,
	 'str_sex'=>$str_sex,
	 
	));
		
		

	$content1 = file_get_contents(_DOC_ROOT.'/hosts/'.HOST.'/conf/member1.conf.php');
	$content2 = file_get_contents(_DOC_ROOT.'/hosts/'.HOST.'/conf/member2.conf.php');
	$content3 = file_get_contents(_DOC_ROOT.'/hosts/'.HOST.'/conf/member3.conf.php');
	$content4 = file_get_contents(_DOC_ROOT.'/hosts/'.HOST.'/conf/member4.conf.php');
	
	
	$tpl->assign($_MEMBER);
	$tpl->assign(array('content1'=>$content1,'content2'=>$content2,'content3'=>$content3,'content4'=>$content4));


	
		if(!$mcode) $DOC_TITLE="str:회원약관동의";

		$tpl->setLayout('@sub');
		$tpl->define('CONTENT',Display::getTemplate('member/join_step2.htm'));

		$tpl->assign($_MEMBER);
		
		
		break;
		
}////


?>