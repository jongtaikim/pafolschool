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

if(!$_SESSION[ADMIN]){
WebApp::moveBack('권한이없습니다.');
exit;
}


$DB = &WebApp::singleton('DB');



function chetVie($oid) {
	global $DB ;
	$mtypes =	 array(
		'n' => '비회원',
		'a'=>'졸업생',
		'g' => '일반',
		's' => '학생',
		'p' => '학부모',
		't' => '교직원',
		'z' => '최고관리자' );


	//총게시물수
	$sql = "select count(*) from TAB_BOARD  ";
	$data['tot_board'] = number_format($DB -> sqlFetchOne($sql));

	//디스크사용량
	$sql = "select sum(num_size) from TAB_FILES  ";
	$tot_file = $DB -> sqlFetchOne($sql);
	$data['tot_file'] = number_format($tot_file/(1024*1024))."MB";

	//회원수
	$sql = "select chr_mtype, count(*) mtype_cnt from TAB_MEMBER group by chr_mtype";
	$row = $DB -> sqlFetchAll($sql);
	for($a=0 ; $a<sizeof($row) ; $a++){
		$chr_mtype = $row[$a]['chr_mtype'];
		$data['tot_user'] += $row[$a]['mtype_cnt'];
		if($mtypes[$chr_mtype]) $row[$a]['mtype'] = $mtypes[$chr_mtype];
		else $row[$a]['mtype'] = "등급없음";
	}

	$data['tot_mtype'] = $row;

	$data['tot_mtype_total'] = $DB->sqlFetchOne("select  count(*)  from TAB_MEMBER  ");
	$data['tot_user'] = number_format($arr['tot_user']);

	return $data;

}

$on_date = chetVie($oid);
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

		$sql = "select str_id,str_name,str_nick, str_handphone, str_phone,chr_mtype from TAB_MEMBER where  chr_mtype in ('a','u','q','k') ";
		$row = $DB -> sqlFetchAll($sql);
		$tpl->assign(array('AMEMBERLIST'=>$row));


		$sql = "select str_re_name, count(str_ip) as counter from TAB_IP_COUNTER  group by str_re_name order by counter desc";
		$row = $DB -> sqlFetchAll($sql);


		$sql = "select count(str_ip)  from TAB_IP_COUNTER ";
		$mac_ccer = $DB -> sqlFetchOne($sql);
		$tpl->assign(array('COUNTERLIST'=>$row,'max_c' =>$mac_ccer));








		$tpl->setLayout();
		$tpl->define("CONTENT", Display::getTemplate("manage/organ_view_all.htm"));


		$tpl->assign(array(

			'mcode'	=>	$mcode,
			'OID' => $oid,
		));	
		
	break;
	case "POST":


	
	
	
	break;
	}

?>