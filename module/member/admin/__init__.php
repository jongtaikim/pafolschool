<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2009-09-11
* 작성자: 김종태
* 설  명: 
*****************************************************************
* 
*/
include_once "module/admin/__init__.php";
$tpl->setLayout('no3');
$_MEMBER = WebApp::getConf('member');
$tpl->assign($_MEMBER);


		
?>