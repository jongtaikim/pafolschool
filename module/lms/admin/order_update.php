<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2012-06-17
* �ۼ���: ������
* ��   ��: ���ݾ�����Ʈ
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');

list($ccode,$serial) = explode("|",$select_ccode);

$sql = "select num_price from TAB_CAMP where num_oid = '$_OID' and num_ccode = '".$ccode."' and num_serial = '".$serial."' ";
echo $DB -> sqlFetchOne($sql);



?>