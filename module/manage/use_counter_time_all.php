<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-11-26
* 작성자: 김종태
* 설   명: 디스트 사용량 뽑기
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');
$color = "AFD8F8,F6BD0F,8BBA00,FF8E46,FF8E46,008E8E,8E468E,588526,B3AA00,008ED6,9D080D,A186BE";
$color = explode(",",$color);

$oids_r = explode("|",$oids);
$oids = $oids_r[0]; 
$day =  $oids_r[1];

if(!$year) $year = date("Y");
if(!$month) $month = date("m");
if(!$day) $day = date("d");


 
 
  for($i=0;$i<25;$i++)
  {
   $sdate=mktime($i,0,0,$month,$day,$year);
   $edate=mktime($i,59,59,$month,$day,$year);


	$sql = "select count(*) from TAB_IP_COUNTER where  num_date >='$sdate' and num_date<='$edate'";


	$total_year_counter = $DB -> sqlFetchOne($sql);



$row[$i]['day_count']=$total_year_counter ;	



$row[$i][str_title]=$i;


			if($ii % 1 == 0) {
				$row[$i]['color'] = "AFD8F8";
			}
			if($ii % 2 == 0) {
				$row[$i]['color'] = "F6BD0F";
			}
			if($ii % 3 == 0) {
			$row[$i]['color'] = "8BBA00";
			}
			if($ii % 4 == 0) {
			$row[$i]['color'] = "FF8E46";
			}
			if($ii % 5 == 0) {
			$row[$i]['color'] = "8BBA00";
			}
			if($ii % 6 == 0) {
			$row[$i]['color'] = "FF8E46";
			}
			if($ii % 7 == 0) {
			$row[$i]['color'] = "008E8E";
			}
			if($ii % 8 == 0) {
			$row[$i]['color'] = "8E468E";
			}
			if($ii % 9 == 0) {
			$row[$i]['color'] = "588526";
			}
			if($ii % 10 == 0) {
			$row[$i]['color'] = "B3AA00";
			}
		


  }
  





 echo '<?xml version="1.0" encoding="euc-kr"?>';

	$tpl->assign(array('LIST'=>$row));
	$tpl->setLayout('blank');
	$tpl->define("CONTENT", Display::getTemplate("manage/use_counter_time.htm"));
	$content = $tpl->fetch('CONTENT');
	
	
	

?>