<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: 
* 작성일: 
* 작성자: 이범민
* 설  명: 
*****************************************************************
* 
*/
 $tpl->setLayout('admin');


		
$tpl->define('CONTENT',WebApp::getTemplate('menu/admin/frame_no.htm'));

$tpl->assign(array('mcode'=>$mcode,'f' => $f));


?>