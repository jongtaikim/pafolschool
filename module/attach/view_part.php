<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: module/attach/view_part.php
* �ۼ���: 2006-05-09
* �ۼ���: �̹���
* ��  ��: <wa:applet> �� ȣ�� ,���̾ƿ� ������ ǥ��
*****************************************************************
* 
*/
$tpl = &WebApp::singleton('Display');
if(!$name) $name = $param['name'];
$FH = &WebApp::singleton('FileHost');
$FH->set_code('main','part');
$msg = file_get_contents(_DOC_ROOT."/hosts/".HOST."/attach/attach.".$name.".msg");// ���������ϰ�
$content = $FH->set_content($msg);
echo $content;
?>