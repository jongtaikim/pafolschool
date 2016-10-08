<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/doc/admin/__del.php
* 작성일: 2005-04-01
* 작성자: 거친마루
* 설  명: 웹문서형 메뉴를 삭제할때 처리할 액션
*****************************************************************
* 
*/

$FH = &WebApp::singleton('FileHost', 'menu', $mcode);
$FH->delete_as_main($mcode);

$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
$FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/doc/'.$fcode.'.'.$mcode.'.msg');
?>
