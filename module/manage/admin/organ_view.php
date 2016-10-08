<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/manage/organ.php
* 작성일: 2008-11-26
* 작성자: 김종태
* 설   명: 학교정보 상세보기
*****************************************************************
* 
*/

$PERM = &WebApp::singleton('Permission');
//array('l'=>'목록보기','r'=>'상세보기','w'=>'호스트생성','m'=>'통계보기'),
$PERM->apply('menu',$mcode,'r');


$DB = &WebApp::singleton('DB');


function chetVie($_OID) {
	global $DB ;
	$mtypes =	WebApp::get('member',array('key'=>'member_types'));


	//총게시물수
	$sql = "select count(*) from TAB_BOARD where num_oid = ".$_OID." ";
	$data['tot_board'] = number_format($DB -> sqlFetchOne($sql));

	//디스크사용량
	$sql = "select sum(num_size) from TAB_FILES where num_oid = ".$_OID." ";
	$tot_file = $DB -> sqlFetchOne($sql);
	$data['tot_file'] = number_format($tot_file/(1024*1024))."MB";

	//회원수
	$sql = "select chr_mtype, count(*) mtype_cnt from TAB_MEMBER where num_oid = ".$_OID." group by chr_mtype";
	$row = $DB -> sqlFetchAll($sql);
	for($a=0 ; $a<sizeof($row) ; $a++){
		$chr_mtype = $row[$a]['chr_mtype'];
		$data['tot_user'] += $row[$a]['mtype_cnt'];
		if($mtypes[$chr_mtype]) $row[$a]['mtype'] = $mtypes[$chr_mtype];
		else $row[$a]['mtype'] = "등급없음";
	}

	$data['tot_mtype'] = $row;

	$data['tot_mtype_total'] = $DB->sqlFetchOne("select  count(*)  from TAB_MEMBER where num_oid = ".$_OID." ");
	$data['tot_user'] = number_format($arr['tot_user']);

	return $data;

}

$on_date = chetVie($_OID);
/*echo "<xmp>";
print_r($on_date);
echo "</xmp>";*/
$tpl->assign($on_date);

switch ($REQUEST_METHOD) {
	case "GET":



		/*	'u' => '중간관리자3', 
			'q' => '중간관리자2', 
			'k' => '중간관리자1', 

		*/


		
		if(!$year) {
			$year = date("Y");
		}


		$tpl->setLayout("no4");

		switch ($mode) {
			case "disk":
			require_once _DOC_ROOT.'/module/file.php';
			
			list($num_disk, $num_upload_size, $db_num_size, $use_size, $maxfilesize) = OIDUploadFileSize();


			$tpl->assign(array(
				'num_disk'=>byte_convert($num_disk),
				'num_upload_size'=>byte_convert($num_upload_size),
				'db_num_size'=>byte_convert($db_num_size),
				'use_size'=>byte_convert($use_size),
				'maxfilesize'=>byte_convert($maxfilesize),
			));


			$oids = _OID;
			$year = $year;		

			if(!$year) $year = date("Y");
			if(!$month) $month = date("m");
			if(!$day) $day = date("d");


			if($month >12) $month=date("m");

			  $year_start=date("Y-m-d",mktime(0,0,0,1,1,$year));
			  $year_last=date("Y-m-d",mktime(23,59,59,12,31,$year));

			$sql = "select sum(num_size) from TAB_FILES where num_oid = $oids and TO_CHAR(dt_date,'YYYY-MM-DD') >='$year_start' and TO_CHAR(dt_date,'YYYY-MM-DD')<='$year_last'";


			$total_year_counter = $DB -> sqlFetchOne($sql);


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


				$sql = "select sum(num_size) from TAB_FILES where num_oid = $oids and TO_CHAR(dt_date,'YYYY-MM-DD')>='$sdate' and TO_CHAR(dt_date,'YYYY-MM-DD')<='$edate'";


				$total_year_counter = $DB -> sqlFetchOne($sql);

				if($total_year_counter){
				$row[$i][file_size]=byte_convert($total_year_counter);	
				}else{
				$row[$i][file_size]=0;
				}
			  
			  }


			$tpl->assign(array('fLIST'=>$row));
			
			






			$tpl->define("CONTENT", Display::getTemplate("manage/admin/disk.htm"));
			
			 break;
			case "member":
	 		
			$sql = "select str_id,str_name,str_nick, str_handphone, str_phone,chr_mtype from TAB_MEMBER where num_oid = $_OID and chr_mtype in ('a','u','q','k') ";
			$row = $DB -> sqlFetchAll($sql);
			$tpl->assign(array('AMEMBERLIST'=>$row));

			 $tpl->define("CONTENT", Display::getTemplate("manage/admin/member.htm"));
			 break;

			 case "board":
			 
			 $tpl->define("CONTENT", Display::getTemplate("manage/admin/board.htm"));
			 break;
			 
			
			case "count":
			



			$oids = _OID;
			$year = $year;		

			if(!$year) $year = date("Y");
			if(!$month) $month = date("m");
			if(!$day) $day = date("d");


			if($month >12) $month=date("m");

			  $year_start= mktime(0,0,0,1,1,$year);
			  $year_last= mktime(23,59,59,12,31,$year);

			$sql = "select  count(str_ip) from TAB_IP_COUNTER where num_oid = $oids and num_date >='$year_start' and num_date<='$year_last'";


			$total_year_counter = $DB -> sqlFetchOne($sql);


			  $max1=1;
			  $max2=1;


			  $mmax=array("31","30","31","30","31","30","31","31","30","31","28","31");
			  $max=1;
			  $max2=1;
			 
			 $row = array();
			
			 $ia = date("m") +1;;
			  for($i=0;$i<date("m");$i++)
			  {
			   $sdate=mktime(0,0,0,$ia-1,1,$year);
			   $edate=mktime(23,59,59,$ia-1,$mmax[$i],$year);

				$sql = "select count(str_ip) from TAB_IP_COUNTER where num_oid = $oids and num_date >='$sdate' and num_date<='$edate'";


				$total_year_counter = $DB -> sqlFetchOne($sql);

				if($total_year_counter>0){
				$row[$ia][dater] = date("m",mktime(0,0,0,$ia-1,1,$year));
				$row[$ia][counter]=$total_year_counter;	
				}
				
				if(($ia-1) == date("m")){
				$max_day = $mmax[$i];
				}
				$ia  = $ia  -1;
				
			
			  }
			
			
			$tpl->assign(array('mLIST'=>$row));
			
			$row2 = array();
			for($ii=0; $ii<$max_day+1; $ii++) {
				$sdate=mktime(0,0,0,$month, $ii+1,$year);
				$edate=mktime(23,59,59,$month, $ii+1,$year);

				$sql = "select count(str_ip) from TAB_IP_COUNTER where num_oid = $oids and num_date >='$sdate' and num_date<='$edate'";
				$total_year_counter = $DB -> sqlFetchOne($sql);

				if($total_year_counter>0){
				$row2[$ii][day] = $ii+1;
				$row2[$ii][counter]=$total_year_counter;	
				}
			}
			
			$tpl->assign(array('dLIST'=>$row2));
	
						
			
			
			/*$sql = "select str_re_name, count(str_ip) as counter from TAB_IP_COUNTER where num_oid = $_OID group by str_re_name order by counter desc";
			$row = $DB -> sqlFetchAll($sql);
			*/

			$sql = "select count(str_ip)  from TAB_IP_COUNTER where num_oid = $_OID ";
			$mac_ccer = $DB -> sqlFetchOne($sql);
			$tpl->assign(array('COUNTERLIST'=>$row,'max_c' =>$mac_ccer));
			
			 $tpl->define("CONTENT", Display::getTemplate("manage/admin/count.htm"));

			break;
			}
		




		$tpl->assign(array(

			'mcode'	=>	$mcode,
			'OID' => $_OID,
			 'year'=>	$year ,
			 'month'=> $month,
		));	
		
	break;
	case "POST":


	
	
	
	break;
	}

?>