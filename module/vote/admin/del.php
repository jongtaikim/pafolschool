<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2009-08-10
* �ۼ���: ������
* ��   ��: ���������
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');


for($ii=1; $ii<20; $ii++) {

unlink(_DOC_ROOT."/hosts/".HOST."/files/vote/".$serial."_".$ii.".gif");	
unlink(_DOC_ROOT."/hosts/".HOST."/files/vote/".$serial."_".$ii.".gif_100");	
}





 $sql = "delete from TAB_VOTE where num_oid = "._OID." and num_serial = '$serial' ";
 if($DB->query($sql)){
 $DB->commit();
 }
 $sql = "delete from TAB_VOTE_USER where num_oid = "._OID." and num_serial = '$serial' ";
 if($DB->query($sql)){
 $DB->commit();
 }
 $sql = "delete from TAB_VOTE_DATA where num_oid = "._OID." and num_serial = '$serial' ";
 if($DB->query($sql)){
 $DB->commit();
 }
WebApp::moveBack('�����Ǿ����ϴ�.');



?>