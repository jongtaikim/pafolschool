<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2007-07-6
* �ۼ���: ������
*****************************************************************
* 
*/


    $tpl = &WebApp::singleton('Display');
    $tpl->define('main_fla',$param['template']);
   
    $content = $tpl->fetch('main_fla');

    echo $content;

	?>