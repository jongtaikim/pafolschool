<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/manage/chat.php
* 작성일: 2008-11-25
* 작성자: 이현민
* 설  명: 학교검색
*****************************************************************
* 
*/

$DB = &WebApp::singleton('DB');
$mtypes = WebApp::get('member',array('key'=>'member_types'));

if(!$page = $_REQUEST['page']) $page = 1;
$listnum = 30;
$offset = ($page-1) * $listnum;

$search_key = $_REQUEST['search_key'];
$search_value = $_REQUEST['search_value'];

if($search_key && $search_value) {

	if($search_key == 'str_organ') {
		$where = "  and str_organ LIKE '%$search_value%'";
	} elseif($search_key == 'str_domain') {
		$where = "  and str_domain LIKE '%$search_value%' OR str_host LIKE '%$search_value%'";
	} elseif($search_key == 'num_oid') {
        $where = "  and num_oid = $search_value";
    }
} 

if(!$code) {
	$code = "SCHOOL";
}

$sql = "SELECT COUNT(*) FROM TAB_ORGAN where  str_hometype = '$code'   $where";
$total = $DB->sqlFetchOne($sql);
if(!$total) {
    $total = 0;
}

$sql = "	
select a.* from (
         select ROWNUM as RNUM, b.* from (
             
 SELECT 
                    num_oid,
                    str_organ,
                    str_title,
                    str_host,
                    str_domain

                FROM ".TAB_ORGAN."

				where str_hometype = '$code' 

                $where
			    order by num_oid desc

)b)a
                where a.RNUM >= ".$offset." and a.RNUM <=($offset+$listnum)";

if($data = $DB->sqlFetchAll($sql)) array_walk($data,'list_format');

$tpl->setLayout();
$tpl->define('CONTENT','module/manage/chat.htm');	

$tpl->assign(array(
	'LIST'			=>	$data,
	'page'			=>	$page,
	'total'			=>	$total,
	'listnum'		=>	$listnum,
	'search_key'	=>	$search_key,
	'search_value'	=>	$search_value,
	'code'	=>	$code
));



function list_format(&$arr) {
	global $DB, $mtypes;

	//총게시물수
	$sql = "select count(*) from TAB_BOARD where num_oid = ".$arr[num_oid]." ";
	$arr['tot_board'] = number_format($DB -> sqlFetchOne($sql));

	//디스크사용량
	$sql = "select sum(num_size) from TAB_FILES where num_oid = ".$arr[num_oid]." ";
	$tot_file = $DB -> sqlFetchOne($sql);
	$arr['tot_file'] = number_format($tot_file/(1024*1024))."MB";

	//회원수
	$sql = "select chr_mtype, count(*) mtype_cnt from TAB_MEMBER where num_oid = ".$arr[num_oid]." group by chr_mtype";
	$row = $DB -> sqlFetchAll($sql);
	for($a=0 ; $a<sizeof($row) ; $a++){
		$chr_mtype = $row[$a]['chr_mtype'];
		$arr['tot_user'] += $row[$a]['mtype_cnt'];
		if($mtypes[$chr_mtype]) $row[$a]['mtype'] = $mtypes[$chr_mtype];
		else $row[$a]['mtype'] = "등급없음";
	}

	$arr['tot_mtype'] = $row;
	$arr['tot_user'] = number_format($arr['tot_user']);

}

?>