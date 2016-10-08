<?
$DB = &WebApp::singleton("DB");

$sql = "select str_thumb, num_serial from tab_board where num_oid = '$_OID' and num_mcode = '191510' ";
$row = $DB -> sqlFetchAll($sql);

for($ii=0; $ii<count($row); $ii++) {
	




$file_name = explode("/pl_pho/",$row[$ii][str_thumb]);
$file_name = explode("_100",$file_name[1]);
$file_name = $file_name[0];

$file_name_exp = explode(".",$file_name);
$file_name_exp = $file_name_exp[1];

$sa = $row[$ii][num_serial];


$sql = "select max(num_serial) + 1 from tab_files where num_oid = '$_OID' str_code = '191510' and  num_main =  '$sa' ";
$max_f = $DB -> sqlFetchOne($sql);
if(!$max_f) $max_f = 1;
echo $max_f;


$sql1="

Insert into ISCH.TAB_FILES
   (NUM_OID, STR_SECT, STR_CODE, NUM_MAIN, NUM_SERIAL, STR_UPFILE, STR_REFILE, STR_FTYPE, NUM_DOWN, NUM_SIZE, DT_DATE, NUM_TA)
 Values
   (20193, 'menu', '191510', '$sa', '$max_f', '$file_name', '$file_name', '$file_name_exp', 0, 0, TO_DATE('03/07/2008 13:27:08', 'MM/DD/YYYY HH24:MI:SS'), 'pl_pho')";


echo $sql1."<br><br>";
 if($DB->query($sql1)){
echo "¼º°ø<br>";
 $DB->commit();
 }

}





?>