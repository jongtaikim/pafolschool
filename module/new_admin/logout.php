<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 날짜 : 2007-08-21
* 모듈 : lms 로그아웃
* 작성자 : 김종태

*****************************************************************
*/

//$_SESSION['ADMIN'] = false;
session_destroy();
setCookie('AUTH',false,-3600,'/','.'.HOST);
setCookie('USERID','',-3600,'/','.'.HOST);
setCookie('NAME','',-3600,'/','.'.HOST);
WebApp::redirect('/?main');
exit;
?>
