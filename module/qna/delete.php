<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2008-01-30
* �ۼ���: ������
* ��  ��: �����Ӹ�~!
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');

 $sql = "delete from TAB_QNA where num_oid = '$_OID'  and num_mcode = '".$mcode."' and num_serial = '".$serial."' ";

 if($DB->query($sql)){
 $DB->commit();
 echo '<script>alert("�����Ǿ����ϴ�.");</script>';
	echo "<meta http-equiv='Refresh' Content=\"0; URL='/qna.list?mcode=".$mcode."&cate=".$cate."'\">";
 
 exit;
 }else{
 echo "sql ���� : ".$sql;
 exit;
 }


?>