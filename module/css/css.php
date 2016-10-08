<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-05-22
* 작성자: 김종태
* 설  명: css 조합기
*****************************************************************
* 
*/


if(!$_CSS) $_CSS = "/THEME/"._THEME."/css/main.css"

$fp = file_get_contents(_DOC_ROOT.$_CSS);
$tpl->assign(array('CSS'=>$fp));






?>