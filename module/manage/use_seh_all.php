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

$sdate=mktime($i,0,0,$month,$day,$year);
$edate=mktime($i,59,59,$month,$day,$year);


 $sql = "select str_re_name, count(str_ip) as counter from TAB_IP_COUNTER  group by str_re_name order by counter desc";
$row = $DB -> sqlFetchAll($sql);
 
  for($i=0;$i<count($row);$i++)
  {
   

$row[$i]['day_count']=$row[$i]['counter'] ;	


if(!$row[$i][str_re_name]) {
$row[$i][str_title]="링크";
	
}else{
$row[$i][str_title]=$row[$i][str_re_name];
}

			if($i % 1 == 0) {
			$row[$i]['color'] = "AFD8F8";
			}
			if($i % 2 == 0) {
				$row[$i]['color'] = "F6BD0F";
			}
			if($i % 3 == 0) {
			$row[$i]['color'] = "8BBA00";
			}
			if($i % 4 == 0) {
			$row[$i]['color'] = "FF8E46";
			}
			if($i % 5 == 0) {
			$row[$i]['color'] = "8BBA00";
			}
			if($i % 6 == 0) {
			$row[$i]['color'] = "FF8E46";
			}
			if($i % 7 == 0) {
			$row[$i]['color'] = "008E8E";
			}
			if($i % 8 == 0) {
			$row[$i]['color'] = "8E468E";
			}
			if($i % 9 == 0) {
			$row[$i]['color'] = "588526";
			}
			if($i % 10 == 0) {
			$row[$i]['color'] = "B3AA00";
			}
		


  }
  





 echo '<?xml version="1.0" encoding="euc-kr"?>';

	$tpl->assign(array('LIST'=>$row));
	$tpl->setLayout('blank');
	$tpl->define("CONTENT", Display::getTemplate("manage/use_seh.htm"));
	$content = $tpl->fetch('CONTENT');
	
	
	

?>