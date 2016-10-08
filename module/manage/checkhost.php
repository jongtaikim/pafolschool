<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/manage/checkhost.php
* 작성일: 2006-04-13
* 작성자: 이범민
* 설  명: 호스트명 중복체크 Response With JSON
*****************************************************************
* 
*/
header('Content-Type: text/html; charset=EUC-KR');
if(!$str_host = $_REQUEST['str_host']) {
    echo '{"Code":"44","Message":"호스트명을 입력하여 주십시오"}';
} elseif(!ereg('^[0-9a-z-]{2,20}$',$str_host)) {
    echo '{"Code":"55","Message":"호스트명은 숫자, 영문 소문자 조합 2자 이상 20자 이하로 입력하여 주십시오."}';
} else {
    $DB = &WebApp::singleton('DB');
    $sql = "SELECT COUNT(*) FROM ".TAB_ORGAN." WHERE str_host='".$str_host;
    if($DB->sqlFetchOne($sql)) {
        echo '{"Code":"66","Message":"호스트명이 이미 사용중입니다."}';
    } else {
        echo '{"Code":"00","Message":"사용가능합니다."}';
    }
}
?>