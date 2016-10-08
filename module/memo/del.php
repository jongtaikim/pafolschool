<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-11-24
* 작성자: 김종태
* 설   명: 쪽지 삭제
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');

 $sql = "delete from TAB_MEMO where num_oid = $_OID and num_serial = '$num_serial'";

 if($DB->query($sql)){
 $DB->commit();
	
echo '<script>alert("취소되었습니다.");</script>';
echo "<meta http-equiv='Refresh' Content=\"0; URL='/memo.send_list'\">";

 }else{
WebApp::moveBack('처리중 오류가 발생하였습니다.');
 }



?>