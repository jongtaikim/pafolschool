<?
/**
* 파일명: module/pop/pop.php
* 작성일: 2007-07-03
* 작성자: 김종태
* 설  명: 노가다를 줄이자
*****************************************************************
* 
*/


$DOC_TITLE = 'str: 학교둘러보기';


$tpl->setLayout('@sub');
$tpl->define('CONTENT',Display::getTemplate('pop/pop.html'));




$tpl->assign(array(
			'img' => $img,
			'dir' => $dir,
			'title_text' => "엘범",	
					));





						
?>