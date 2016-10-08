<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-01-30
* 작성자: 김종태
* 설  명: 몰라임마~!
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');
if($mode =="del") {
$sql = "delete from ".TAB_ATTACH_CONFIG_TEM." where num_oid = '"._OID."' and str_layout = '$layout' and num_date =  ".$date." and num_css="._CSS."";
$DB->query($sql);
$DB->commit();

$sql = "delete from ".TAB_CSS_TEM." where num_oid = '"._OID."' and str_layout = '$layout' and num_date =  ".$date." and num_serial="._CSS."";
$DB->query($sql);
$DB->commit();

$sql = "delete from ".TAB_CSS_CONFIG." where num_oid = '"._OID."' and str_layout = '$layout' and dt_date =  ".$date." and num_css="._CSS."";
$DB->query($sql);
$DB->commit();
echo '<script>alert("백업이 삭제되었습니다.");</script>';
exit;	
}

////////////////////////////////////////////////////////////////////////////////



$sql = "delete from ".TAB_ATTACH_CONFIG." where num_oid = '"._OID."' and str_layout = '$layout' and num_css="._CSS."";
$DB->query($sql);
$DB->commit();



$sql = "select * from ".TAB_ATTACH_CONFIG_TEM." where num_oid = '"._OID."' and str_layout = '$layout' and num_date =  ".$date." and num_css="._CSS."";
$row = $DB -> sqlFetchAll($sql);

for($iii=0; $iii<count($row); $iii++) {


unset($row[$iii][num_date]);	
$DB-> insertQuery("TAB_ATTACH_CONFIG",$row[$iii]);
$DB->commit();
}




$sql = "delete from ".TAB_CSS." where num_oid = '"._OID."' and str_layout = '$layout' and num_serial="._CSS."";
$DB->query($sql);
$DB->commit();



$sql = "select * from ".TAB_CSS_TEM." where num_oid = '"._OID."' and str_layout = '$layout' and num_date =  ".$date." and num_serial="._CSS."";


$row = $DB -> sqlFetchAll($sql);

for($iii=0; $iii<count($row); $iii++) {
unset($row[$iii][num_date]);	
$DB-> insertQuery("TAB_CSS",$row[$iii]);
$DB->commit();
}




$mkb = mktime() - (86400 * 30);


$sql = "delete from ".TAB_ATTACH_CONFIG_TEM." where  num_date <  ".$mkb."";
$DB->query($sql);
$DB->commit();

$sql = "delete from ".TAB_CSS_TEM." where  num_date <  ".$mkb."";
$DB->query($sql);
$DB->commit();

// 30일 지난건 자동 삭제


 include dirname(__FILE__).'/makelayer.php';
makelayer($layout);

WebApp::moveBack();




?>