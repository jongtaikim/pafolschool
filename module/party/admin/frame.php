<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/party/admin/frame.php
* 작성일: 2006-05-16
* 작성자: 이범민
* 설  명: 
*****************************************************************
* 
*/
$tpl->setLayout('p');
$tpl->define('CONTENT','html/party/admin/frame.htm');
$tpl->assign(array('mode'=>$mode,'link'=>$link));
?>