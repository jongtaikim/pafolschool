<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-04-17
* 작성자: 김종태
* 설  명: 카운터 보이기
*****************************************************************
* 
*/
	
	$cache_file = _DOC_ROOT.'/hosts/'.HOST.'/inc.'.$mou_name.'.htm';


	if(!is_file($cache_file) || date('Ymd H') > date('Ymd H',filemtime($cache_file))) {
   $make ="y";
   $DB = &WebApp::singleton('DB');

	//2008-12-17 오늘 카운터
   $sdate=mktime(0,0,0,date("m"),date("d"),date("Y"));
   $edate=mktime(23,59,59,date("m"),date("d"),date("Y"));
   $sql = "select count(*) from TAB_IP_COUNTER where num_oid = "._OID."  and num_date >='$sdate' and num_date<='$edate'";
   $today_counter = $DB -> sqlFetchOne($sql);
	
	//2008-12-17 어제 카운터
   $sdate=mktime(0,0,0,date("m"),date("d")-1,date("Y"));
   $edate=mktime(23,59,59,date("m"),date("d")-1,date("Y"));
   $sql = "select count(*) from TAB_IP_COUNTER where num_oid = "._OID."  and num_date >='$sdate' and num_date<='$edate'";
   $today_counter_1 = $DB -> sqlFetchOne($sql);

   //2008-12-17 전체 카운터
   $sql = "select count(*) from TAB_IP_COUNTER where num_oid = "._OID." ";
   $total_counter = $DB -> sqlFetchOne($sql);

   $tpl->assign(array(
   'today_counter'=>$today_counter,
   'today_counter_1'=>$today_counter_1,
   'total_counter'=>$total_counter
   ));
	
   	$content = $tpl->fetch($mou_name.'_W_');
	}else{
	$content =  file_get_contents($cache_file);
	}

?>
