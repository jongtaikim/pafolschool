<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2008-01-30
* �ۼ���: ������
* ��  ��: ����Ʈ ��û
*****************************************************************
* 
*/
$DB = &WebApp::singleton("DB");
switch ($REQUEST_METHOD) {
	case "GET":
	
	$tpl->setLayout('admin');
	$tpl->define("CONTENT", "/html/member/jinsung_chk.htm");
	
	 break;
	case "POST":



$sql = "select STR_CONFIRM_CODE from TAB_MEM_CONFIRM where num_oid = '$_OID' and STR_CONFIRM2 = '$str_confirm1'
 AND STR_NAME = '$str_name' ";

$id_rr = $DB -> sqlFetchOne($sql);
if(!$id_rr) {
WebApp::moveBack('��ġ�ϴ� ������ �����ϴ�.');

}else{

$sql = "select count(str_id) from TAB_MEMBER where num_oid = '$_OID' and str_id = '$id_rr' ";
$chk1 = $DB -> sqlFetchOne($sql);

if($chk1 > 0) {
WebApp::moveBack('�̹� ȸ�����ԵǾ��ִ� �����ڵ��Դϴ�. �����ڿ��� Ȯ���غμ���.');	
exit;
}



$haknun = substr($id_rr , 5 ,1);
$ban = substr($id_rr , 6 ,2) -1;

echo "<script>
parent.closew2();
parent.selint('$id_rr','$haknun','$ban','$str_name');
</script>";
}

	 break;
	}

?>

 