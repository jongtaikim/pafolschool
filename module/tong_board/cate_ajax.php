<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2009-02-23
* 작성자: 김종태
* 설   명: 카테고리 불러오기
*****************************************************************
* 
*/

$DB = &WebApp::singleton('DB');

$sql = "select str_category from TAB_BOARD_CATEGORY where num_oid = $_OID and num_mcode = $mcode ";

$row = $DB -> sqlFetchAll($sql);


$a = '<br>
카테고리 : <select name="cate" style="font-size:11px">
  <option value="일반">일반</option>';
  echo $a;
?>

<?
for($ii=0; $ii<count($row); $ii++) {
echo '<option value='.$row[$ii][str_category].'>'. $row[$ii][str_category].'</option>';	
}

?>
 </select>