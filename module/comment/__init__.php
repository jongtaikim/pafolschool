<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2010-01-29
* �ۼ���: ������
* ��   ��: �ƹ����� ���� �۷ι� �Լ�
*****************************************************************
* 
*/
$tpl = &WebApp::singleton('Display');
if(!$param['comment_skin']) $comment_skin = "basic"; else $comment_skin = $param['comment_skin'];
if(!$param['len']) $len = "4000"; else $len = $param['len'];
if(!$param['comment_title']) $title = "����"; else $title = $param['comment_title'];

$mou_name = "comment";

$tpl->assign($param);


?>