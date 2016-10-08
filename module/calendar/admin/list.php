<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/lunch/admin/list.php
* 작성일: 2006-05-18
* 작성자: 이범민
* 설  명: 행사일정 관리자
*****************************************************************
* 
*/
$DB = WebApp::singleton('DB');
$FH = &WebApp::singleton('FileHost','main','calendar');

if(!$ym = $_REQUEST['ym']) $ym = date('Ym');
$year = substr($ym,0,4);
$month = substr($ym,4,2);
$id = $_REQUEST['id'];

if($y){
$year = $y;
$month = date("m");
$ym = $year.$month;
}

switch($REQUEST_METHOD) {
	case "GET":


        

        $startdate = $ym."01";
        $lastdate = $ym.date('t',strtotime($year.'-'.$month.'-01'));
        
		$sql = "SELECT /*+ INDEX (".TAB_CALENDAR." ".PK_TAB_CALENDAR.") */ num_date, num_serial, str_title, str_text, num_icon, num_hit, str_dday ".
               "FROM ".TAB_CALENDAR." WHERE num_oid=".$_OID." AND num_date >= $startdate AND num_date <= $lastdate";
		 $row = $DB -> sqlFetchAll($sql);
		 $tpl->assign(array('LIST'=>$row));
     
     

        $sdate = date('Y/m/d',strtotime($startdate));
        $prev_ym = date('Ym',strtotime($sdate.' -1 year'));
        $prev_y = substr($prev_ym,0,4);
        $prev_m = substr($prev_ym,4,2);
        $next_ym = date('Ym',strtotime($sdate.' +1 year'));
        $next_y = substr($next_ym,0,4);
        $next_m = substr($next_ym,4,2);



        $tpl->define('CONTENT','html/calendar/admin/list.htm');
        $tpl->assign(array(
            'skin'     => $skin,
            'ym'       => $ym,
            'id'       => $id,
            'year'     => $year,
            'month'    => $month,
            'prev_ym'  => $prev_ym,
            'prev_y'   => $prev_y,
            'prev_m'   => $prev_m,
            'next_ym'  => $next_ym,
            'next_y'   => $next_y,
            'next_m'   => $next_m,
			'f'   => $f
        ));
        break;
    case "POST":
	
	for($ii=0; $ii<count($serial); $ii++) {
		 $sql = "delete from TAB_CALENDAR WHERE num_oid=$_OID and num_serial = ".$serial[$ii]."";
		 $DB->query($sql);
	}
	 $DB->commit();	
	
	 WebApp::moveBack(count($serial).'개의 일정이 삭제되었습니다.');
	 
       
        break;
}
?>