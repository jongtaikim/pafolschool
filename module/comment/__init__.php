<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2010-01-29
* 작성자: 김종태
* 설   명: 아무데나 덧글 글로벌 함수
*****************************************************************
* 
*/
$tpl = &WebApp::singleton('Display');
if(!$param['comment_skin']) $comment_skin = "basic"; else $comment_skin = $param['comment_skin'];
if(!$param['len']) $len = "4000"; else $len = $param['len'];
if(!$param['comment_title']) $title = "덧글"; else $title = $param['comment_title'];

$mou_name = "comment";

$tpl->assign($param);


?>