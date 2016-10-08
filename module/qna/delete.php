<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-01-30
* 작성자: 김종태
* 설  명: 몰라임마~!
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');

 $sql = "delete from TAB_QNA where num_oid = '$_OID'  and num_mcode = '".$mcode."' and num_serial = '".$serial."' ";

 if($DB->query($sql)){
 $DB->commit();
 echo '<script>alert("삭제되었습니다.");</script>';
	echo "<meta http-equiv='Refresh' Content=\"0; URL='/qna.list?mcode=".$mcode."&cate=".$cate."'\">";
 
 exit;
 }else{
 echo "sql 에러 : ".$sql;
 exit;
 }


?>