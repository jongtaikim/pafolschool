<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2008-05-22
* �ۼ���: ������
* ��  ��: css ���ձ�
*****************************************************************
* 
*/


if(!$_CSS) $_CSS = "/THEME/"._THEME."/css/main.css"

$fp = file_get_contents(_DOC_ROOT.$_CSS);
$tpl->assign(array('CSS'=>$fp));






?>