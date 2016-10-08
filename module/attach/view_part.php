<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/attach/view_part.php
* 작성일: 2006-05-09
* 작성자: 이범민
* 설  명: <wa:applet> 로 호출 ,레이아웃 컨텐츠 표시
*****************************************************************
* 
*/
$tpl = &WebApp::singleton('Display');
if(!$name) $name = $param['name'];
$FH = &WebApp::singleton('FileHost');
$FH->set_code('main','part');
$msg = file_get_contents(_DOC_ROOT."/hosts/".HOST."/attach/attach.".$name.".msg");// 파일지정하고
$content = $FH->set_content($msg);
echo $content;
?>