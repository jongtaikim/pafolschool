<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: list.php
* 작성일: 2008-05-07
* 작성자: 김종태
* 설  명: 
*****************************************************************
* 
*/

//2008-05-07 메뉴에 등록된 부분이 있을경우 해당 매뉴페이지로 이동 종태
if(!$mcode) {
$DB = &WebApp::singleton("DB");
$sql = "select num_mcode from TAB_MENU where num_oid = '$_OID' and str_type = 'link#cal' ";
$mcode_meta = $DB -> sqlFetchOne($sql);	
if($mcode_meta) {
if(strstr($REQUEST_URI,"?")){
echo "<meta http-equiv='Refresh' Content=\"0; URL='".$REQUEST_URI."&mcode=$mcode_meta'\">";
}else{
echo "<meta http-equiv='Refresh' Content=\"0; URL='".$REQUEST_URI."?mcode=$mcode_meta'\">";
}
exit;

}
}


$DOC_TITLE = "str:학사일정";

$DB = WebApp::singleton('DB');

if(!$ym = $_REQUEST['ym']) $ym = date('Ym');
$year = substr($ym,0,4);
$month = substr($ym,4,2);



$CAL = &WebApp::singleton('Calendar',$year,$month);

$CAL ->month = $month;
$CAL ->year = $year;

$startdate = $ym."01";
$lastdate = $ym.date('t',strtotime($year.'-'.$month.'-01'));
$sql = "SELECT /*+ INDEX (".TAB_CALENDAR." ".PK_TAB_CALENDAR.") */ num_date, num_serial, str_title, str_text, num_icon, num_hit ".
       "FROM ".TAB_CALENDAR." WHERE num_oid=".$_OID." AND num_date >= $startdate AND num_date <= $lastdate";
$DB->query($sql);

while($row = $DB->fetch()) {

	$CAL->setEvent(substr($row['num_date'],6,2), $row, true);
}



$sdate = date('Y/m/d',strtotime($startdate));
$prev_ym = date('Ym',strtotime($sdate.' -1 month'));
$prev_y = substr($prev_ym,0,4);
$prev_m = substr($prev_ym,4,2);
$next_ym = date('Ym',strtotime($sdate.' +1 month'));
$next_y = substr($next_ym,0,4);
$next_m = substr($next_ym,4,2);




$tpl->setLayout();
$tpl->define("CONTENT", WebApp::getTemplate("calendar/skin/".$skin."/list.htm"));
$tpl->assign(array(
    'calskin'     => $skin,
    'LIST_cal'     => $CAL->get_array(),
    'ym'       => $ym,
    'tt'       => $_SESSION[MEM_TYPE][0],
	'id'       => $id,
    'year'     => $year,
    'month'    => $month,
    'prev_ym'  => $prev_ym,
    'prev_y'   => $prev_y,
    'prev_m'   => $prev_m,
    'next_ym'  => $next_ym,
    'next_y'   => $next_y,
    'next_m'   => $next_m
));
?>