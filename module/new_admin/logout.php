<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ��¥ : 2007-08-21
* ��� : lms �α׾ƿ�
* �ۼ��� : ������

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
