<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-06-24
* 작성자: 김종태
* 설  명: 상상학교 메인에 컬럼 노출
*****************************************************************
* 
*/
$DB = &WebApp::singleton("DB");


$sql = "update TAB_BOARD set str_main = '$str_main'  where num_oid = '$_OID' and num_mcode = $mcode and num_serial = $id";
$DB->query($sql);
$DB->commit();


if($str_main) {
WebApp::moveBack('컬럼으로 지정되었습니다.');	
}else{
WebApp::moveBack('컬럼이 해제되었습니다.');
}





?>