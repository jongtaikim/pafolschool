<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: main.php
* 작성일: 2007-08-24
* 작성자: 김종태
* 설  명: 관리자 메인
*****************************************************************
* 
*/

$DB = &WebApp::singleton('DB');

// lms 기본 설정 검사 및 설치입니다.




$tpl->setLayout('frameset');

$tpl->define('CONTENT',WebApp::getTemplate('new_admin/main.htm'));



if(!$m) $m = 0;


switch($m) {
	
	case '0':

	$tpl->assign(array(
		'main'=>"/new_admin.index",
		'menu'=>"/html/1.inc",
	));	

	break;
	case '1':

	$tpl->assign(array(
	'main'=>"/new_admin.index?mode=1",
	'menu'=>"/html/".$m.".inc",
	));	
	
	break;
	
	case '2':

	$tpl->assign(array(
		'menu'=>"new_admin.menu",
		'main'=>"attach.admin.manage",
	));	
	break;  





	case '3':

	$tpl->assign(array(
	'main'=>"member.admin.list",
	'menu'=>"/html/".$m.".inc",
	));	
	
	break;
	
		case '4':

	$tpl->assign(array(
	'main'=>"/class.manage.frame",
	'menu'=>"/html/".$m.".inc",
	));	
	
	break;


		case '5':

	$tpl->assign(array(
	'main'=>"",
	'menu'=>"/html/".$m.".inc",
	));	
	
	break;

		case '6':

	$tpl->assign(array(
	'main'=>"/admin.main.list?code=com",
	'menu'=>"/html/".$m.".inc",
	));	
	
	break;


		case '7':

	$tpl->assign(array(
	'main'=>"/latestboard.admin.list?type=B",
	'menu'=>"/html/1.inc",
	));	
	
	break;


		case '8':

	$tpl->assign(array(
	'main'=>"http://ij3.iknock.co.kr/board.list?mcode=90000",
	'menu'=>"/html/6.inc",
	));	
	
	break;
	
		case '9':

	$tpl->assign(array(
	'main'=>"http://app.na4.com/npaint_f/app_client.php?layout_type=1&layout_size=1",
	'menu'=>"/html/6.inc",
	));	
	
	break;




}


?>
