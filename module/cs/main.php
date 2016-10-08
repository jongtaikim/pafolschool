<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2007-07-6
* 작성자: 김종태
*****************************************************************
* 
*/


    $tpl = &WebApp::singleton('Display');
    $tpl->define('bank',$param['template']);
   
	$tpl->assign(array(
	'tel'=>_OPHONE,

	));
    $content = $tpl->fetch('bank');



    echo $content;

	?>