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


function chetVie($oids) {
	global $DB ;
	$mtypes =	WebApp::get('member',array('key'=>'member_types'));

	//총게시물수
	$sql = "select count(*) from TAB_BOARD where num_oid = ".$oids." ";
	$data['tot_board'] = number_format($DB -> sqlFetchOne($sql));

	//디스크사용량
	$sql = "select sum(num_size) from TAB_FILES where num_oid = ".$oids." ";
	$tot_file = $DB -> sqlFetchOne($sql);
	$data['tot_file'] = number_format($tot_file/(1024*1024))."MB";

	//회원수
	$sql = "select chr_mtype, count(*) mtype_cnt from TAB_MEMBER where num_oid = ".$oids." group by chr_mtype";
	$row = $DB -> sqlFetchAll($sql);
	for($a=0 ; $a<sizeof($row) ; $a++){
		$chr_mtype = $row[$a]['chr_mtype'];
		$data['tot_user'] += $row[$a]['mtype_cnt'];
		if($mtypes[$chr_mtype]) $row[$a]['mtype'] = $mtypes[$chr_mtype];
		else $row[$a]['mtype'] = "등급없음";
	}

	$data['tot_mtype'] = $row;

	$data['tot_mtype_total'] = $DB->sqlFetchOne("select  count(*)  from TAB_MEMBER where num_oid = ".$oids." ");
	$data['tot_user'] = number_format($arr['tot_user']);

	return $data;

}

$on_date = chetVie($oids);
/*echo "<xmp>";
print_r($on_date);
echo "</xmp>";*/
$tpl->assign($on_date);



function chetVieAll() {
	global $DB ;

	//총게시물수
	$sql = "select count(*) from TAB_BOARD  ";
	$data['tot_board'] = number_format($DB -> sqlFetchOne($sql));

	//디스크사용량
	$sql = "select sum(num_size) from TAB_FILES ";
	$tot_file = $DB -> sqlFetchOne($sql);
	$data['tot_file'] = number_format($tot_file/(1024*1024))."MB";

	$data['tot_mtype_total'] = $DB->sqlFetchOne("select  count(*)  from TAB_MEMBER ");
	$data['tot_user'] = number_format($arr['tot_user']);

	return $data;

}


//print_r(chetVie($oids));
//print_r(chetVieAll());


switch ($REQUEST_METHOD) {
	case "GET":

$sql = "	
 SELECT 
                  
                  num_oid,
                  str_organ,
                  str_title,
                  str_host,
                  str_domain,
                  str_theme,
                  str_password,
                  str_ceo_name,
                  str_ceo_email,
                  str_phone,
                  str_fax,
                  chr_zip,
                  str_addr1,
                  str_addr2,
                  str_master_name,
                  str_master_email,
                  str_master_phone,
                  str_master_mobile,
 				  str_end_date,
                  TO_CHAR(dt_date,'YYYY-MM-DD') dt_date,
				  str_hg_code,
				  str_sa_number,
				  str_st,
				  str_end_date,
				  str_bi,
				  num_disk,
				  num_upload_size,
				  str_text



                FROM ".TAB_ORGAN." 

				where 

				num_oid = $oids and

				str_hometype = 'HOME'
				

                $where
			    order by num_oid desc
";

	//echo $sql;
	$data = $DB->sqlFetch($sql);

$data[num_disk] = $data[num_disk] / (1024*1024);	
$data[num_upload_size] = $data[num_upload_size] / (1024*1024);	

$tpl->assign($data);

/*	'u' => '중간관리자3', 
	'q' => '중간관리자2', 
	'k' => '중간관리자1', 

*/

$sql = "select str_id,str_name,str_nick, str_handphone, str_phone,chr_mtype from TAB_MEMBER where num_oid = $oids and chr_mtype in ('a','u','q','k') ";
$row = $DB -> sqlFetchAll($sql);
$tpl->assign(array('AMEMBERLIST'=>$row));


$sql = "select str_re_name, count(str_ip) as counter from TAB_IP_COUNTER where num_oid = $oids group by str_re_name order by counter desc";
$row = $DB -> sqlFetchAll($sql);


$sql = "select count(str_ip)  from TAB_IP_COUNTER where num_oid = $oids ";
$mac_ccer = $DB -> sqlFetchOne($sql);
$tpl->assign(array('COUNTERLIST'=>$row,'max_c' =>$mac_ccer));




$tpl->setLayout();
$tpl->define("CONTENT", Display::getTemplate("manage/organ_view.htm"));


$tpl->assign(array(

	'mcode'	=>	$mcode,
	'oids' => $oids,
));	
	
	 break;
	case "POST":

if($num_disk) {
$num_disk = $num_disk * (1024*1024);	
$sql1 = "num_disk ='$num_disk',";
}else{
$sql1 = "num_disk ='',";
}

if($num_upload_size) {
$num_upload_size = $num_upload_size * (1024*1024);
$sql2 = "num_upload_size ='$num_upload_size',";
}else{
$sql2 = "num_upload_size ='',";
}


 $sql = "UPDATE ".TAB_ORGAN." SET 
 
str_organ ='$str_organ',
str_sa_number ='$str_sa_number',
str_hg_code ='$str_hg_code',
str_ceo_name ='$str_ceo_name',
str_phone ='$str_phone',
str_fax ='$str_fax',
chr_zip ='$chr_zip',
str_addr1 ='$str_addr1',
str_addr2 ='$str_addr2',
str_master_name ='$str_master_name',
str_master_email ='$str_master_email',
str_master_phone ='$str_master_phone',
str_master_mobile ='$str_master_mobile',
str_st ='$str_st',
str_title ='$str_title',
str_end_date ='$str_end_date',
str_text = '$str_text',
$sql1 
$sql2
str_bi ='$str_bi'



 
 WHERE num_oid=$oids";
 if($DB->query($sql)){
 $DB->commit();
 
  WebApp::moveBack('수정되었습니다.');
 
 }else{

 WebApp::moveBack($DB->error);
  $DB->commit();
 }





	
	
	
	break;
	}

?>