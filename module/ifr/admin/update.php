<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-01-30
* 작성자: 김종태
* 설  명: 주문상태 변경
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');

if(isset($val) && isset($id)){
	$sql = "UPDATE EZFLV.TB_CONTENT SET str_main_view='".$val."'  WHERE str_content_id=$id";
}

if($DB->query($sql)){
	$DB->commit();
	echo "Y";
}

?>