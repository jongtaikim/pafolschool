<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2009-09-03
* �ۼ���: ������
* ��   ��: �޴����� mcode ������ ���¶�
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
	WebApp::moveBack('������');
	exit;
 }else{
	echo "sql ���� : ".$sql;
	 exit;
 }

?>