<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: delete_check.php
* 작성일: 2005-07-21
* 작성자: 이범민
* 설  명: 중복확인 데이타(IP,ID)를 삭제
*****************************************************************
* 
*/
if(!$id = $_REQUEST['id']) WebApp::raiseError('잘못된 요청입니다.');
$DB = &WebApp::singleton('DB');

$sql = "DELETE FROM ".TAB_POLL_IP." WHERE NUM_OID=$OID AND NUM_MAIN=$id";
$DB->query($sql);
$DB->commit();

$sql = "DELETE FROM ".TAB_POLL_USER." WHERE NUM_OID=$OID AND NUM_MAIN=$id";
$DB->query($sql);
$DB->commit();

WebApp::redirect($URL->setVar(array('act'=>'.list','id'=>$id)), '삭제되었습니다.');
?>