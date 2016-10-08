<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2007-07-6
* 작성자: 김종태
*****************************************************************
* 
*/


    $tpl = &WebApp::singleton('Display');
    $tpl->define('main_fla',$param['template']);
   
    $content = $tpl->fetch('main_fla');

    echo $content;

	?>