<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2009-09-03
* 작성자: 김종태
* 설   명: 메뉴정렬 mcode 순으로 리셋또
*****************************************************************
* 
*/

unset($_SESSION[ses_cate]);

$DB = &WebApp::singleton('DB');
 $sql = "update TAB_MENU set num_cate = num_mcode  WHERE num_oid=$_OID";

 if($DB->query($sql)){
 
 
 

 $sql = "UPDATE ".TAB_MENU." SET num_step=num_step_back WHERE num_oid=$_OID ";
$DB->query($sql);
 
 
 
 
 
 

 
 
 $DB->commit();
 	 exec("rm -rf "._DOC_ROOT."/hosts/".HOST."/inc_menu/*.htm");
	 exec("rm -rf "._DOC_ROOT."/hosts/".HOST."/menu.xml");
	WebApp::moveBack('수정됨');
	exit;
 }else{
	echo "sql 에러 : ".$sql;
	 exit;
 }

?>