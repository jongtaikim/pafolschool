<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-06-24
* 작성자: 김종태
* 설  명:  추천
*****************************************************************
* 
*/
if(!$_SESSION['USERID']) {
WebApp::moveBack('로그인이 필요합니다.');	
exit;
}

if($_SESSION['USERID'] == $user_id) {
WebApp::moveBack('자신의 글을 추천할 수 없습니다.');	
exit;
}


if(strstr($_SESSION['S_MCODE'],$mcode."|".$id)) {
WebApp::moveBack('이미 추천한 글입니다.');	
exit;
}


$DB = &WebApp::singleton("DB");

$sql = "update TAB_BOARD set num_rank = num_rank +1  where num_oid = '$_OID' and num_mcode = $mcode and num_serial = $id";
$DB->query($sql);
$DB->commit();

$_SESSION['S_MCODE'] .= $mcode."|".$id;


WebApp::moveBack('추천되었습니다.');	






?>