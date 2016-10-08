<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/party/doc/admin/__del.php
* 작성일: 2006-05-17
* 작성자: 이범민
* 설  명: 웹문서형 메뉴를 삭제할때 처리할 액션
*****************************************************************
* 
*/

$FH = &WebApp::singleton('FileHost');
$FH->set_code('party', $pcode.'.'.$mcode);
$FH->delete_as_code();

$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
$FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/doc/party.'.$pcode.'.'.$mcode.'.msg');
?>
