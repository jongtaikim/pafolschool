<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/manage/organ.php
* 작성일: 2008-11-26
* 작성자: 김종태
* 설  명:  학교정보검색
*****************************************************************
* 
*/


$PERM = &WebApp::singleton('Permission');
//array('l'=>'목록보기','r'=>'상세보기','w'=>'호스트생성','m'=>'통계보기'),
//$PERM->apply('menu',$mcode,'l');

$DB = &WebApp::singleton('DB');
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

$sql = "SELECT COUNT(*) FROM TAB_ORGAN where  str_hometype = 'HOME'   $where";
$total = $DB->sqlFetchOne($sql);
if(!$total) $total = 0;

$sql = "	
select a.* from (
         select ROWNUM as RNUM, b.* from (
             
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
                  TO_CHAR(dt_date,'YYYY-MM-DD') dt_date



                FROM ".TAB_ORGAN." 

				where 

				str_hometype = 'HOME'
				

                $where
			    order by num_oid desc

)b)a
                where a.RNUM >= ".$offset." and a.RNUM <=($offset+$listnum)";

	//echo $sql;
	$data = $DB->sqlFetchAll($sql);




$tpl->setLayout();
$tpl->define("CONTENT", Display::getTemplate("manage/organ_list.htm"));



$tpl->assign(array(
	'LIST'			=>	$data,
	'page'			=>	$page,
	'total'			=>	$total,
	'listnum'		=>	$listnum,
	'search_key'	=>	$search_key,
	'search_value'	=>	$search_value,
	'mcode'	=>	$mcode
));
?>