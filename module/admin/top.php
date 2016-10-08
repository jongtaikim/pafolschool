<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/admin/top.php
* 작성일: 2005-05-25
* 작성자: 거친마루
* 설  명: 관리자모드 상단 출력
*****************************************************************
* 
*/
$tpl->setLayout('admin');
$tpl->assign(array('mode'=>$mode));
$tpl->define('CONTENT', Display::getTemplate('top_c.htm'));
?>
