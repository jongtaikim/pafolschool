<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: __init__.php
* 작성일: 2005-03-24
* 작성자: 거친마루
* 설  명: 메뉴관리
*****************************************************************
* 
*/
include_once "module/admin/__init__.php";
$VAR_MENUTYPE = array(
		'menu' => _('Blank Menu'),
		'doc' => _('HTML Document'),
		'board#B' => _('Bulletin Board'),
		'council' => _('Counselling Room'),
		'board#G' => _('Image Gallery'),
		'link' => _('URL Link'),
/*		'I' => _('School Symbol'), */
		'history' => _('History')
/*		,'S' => _('Professor Introduce Wizard')*/
	);
?>