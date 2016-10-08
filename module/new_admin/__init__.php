<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 날짜 : 2007-08-21
* 모듈 :  어드민 통합
* 작성자 : 김종태

*****************************************************************
* 
*/
if($_SERVER[HTTP_HOST] != "ij1.iknock.co.kr"){
if($RUN_MODE == WEBAPP_RUNMODE_GLOBAL) {
    
    function check_admin_auth() {
        if(check_edumark_ip()) $_SESSION['ADMIN'] = true;
        return $_SESSION['ADMIN'];
    }
    
    if($flg!='t')
    if (!check_admin_auth() && $act != 'new_admin.login' && $act != 'new_admin.logout') {
        $_SESSION['redir'] = getenv('REQUEST_URI');
        WebApp::redirect('new_admin.login');
    }
}
}
?>