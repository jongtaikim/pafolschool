<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2009-02-23
* �ۼ���: ������
* ��   ��: ī�װ� �ҷ�����
*****************************************************************
* 
*/

$DB = &WebApp::singleton('DB');

$sql = "select str_category from TAB_BOARD_CATEGORY where num_oid = $_OID and num_mcode = $mcode ";

$row = $DB -> sqlFetchAll($sql);


$a = '<br>
ī�װ� : <select name="cate" style="font-size:11px">
  <option value="�Ϲ�">�Ϲ�</option>';
  echo $a;
?>

<?
for($ii=0; $ii<count($row); $ii++) {
echo '<option value='.$row[$ii][str_category].'>'. $row[$ii][str_category].'</option>';	
}

?>
 </select>