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

$year_e = explode("|",$year);
$oids = $year_e[0];
$year = $year_e[1];		

if(!$year) $year = date("Y");
if(!$month) $month = date("m");
if(!$day) $day = date("d");


if($month >12) $month=date("m");

  $year_start=date("Y-m-d",mktime(0,0,0,1,1,$year));
  $year_last=date("Y-m-d",mktime(23,59,59,12,31,$year));

$sql = "select count(*) from TAB_BOARD where  TO_CHAR(dt_date,'YYYY-MM-DD') >='$year_start' and TO_CHAR(dt_date,'YYYY-MM-DD')<='$year_last'";


$total_year_counter = $DB -> sqlFetchOne($sql);

if($total_year_counter > 0) {
	

$max1=1;
  $max2=1;

  $mmax=array("31","28","31","30","31","30","31","31","30","31","30","31");
  $max=1;
  $max2=1;
 
 $row = array();
  for($i=0;$i<12;$i++)
  {
   $sdate=date("Y-m-d",mktime(0,0,0,$i+1,1,$year));
   $edate=date("Y-m-d",mktime(23,59,59,$i+1,$mmax[$i],$year));


	$sql = "select count(*) from TAB_BOARD where  TO_CHAR(dt_date,'YYYY-MM-DD')>='$sdate' and TO_CHAR(dt_date,'YYYY-MM-DD')<='$edate'";


	$total_year_counter = $DB -> sqlFetchOne($sql);


$row[$i][total_price]=$total_year_counter ;	



$row[$i][str_title]=$i+1;


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
  

}



 echo '<?xml version="1.0" encoding="euc-kr"?>';

	$tpl->assign(array('LIST'=>$row));
	$tpl->setLayout('blank');
	$tpl->define("CONTENT", Display::getTemplate("manage/use_board.htm"));
	$content = $tpl->fetch('CONTENT');
	
	
	

?>