<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2011-08-03
* �ۼ���: ������
* ��   ��: ��ũ üƮ �� �̵�
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');

 $sql = "UPDATE ".$table." SET num_hit=num_hit+1 WHERE num_oid=$_OID and str_url = '".$urls."'";
 if($DB->query($sql)){
  $DB->commit();
}
echo "<meta http-equiv='Refresh' Content=\"0; URL='$urls'\">";
exit;

?>