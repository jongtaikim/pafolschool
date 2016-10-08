<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: select.php
* 작성일: 2008-03-04
* 작성자: 김종태
* 설  명: 메인에 서비스 현황 출력
*****************************************************************
* 
*/


$DB = &WebApp::singleton('DB');

$sql = "

   num_step, str_end_date, TO_CHAR(dt_date,'YYYY-MM-DD') dt_date, 
   str_home_type, str_design, str_opt1, 
   str_opt2, str_opt3, str_name, 
   str_organ, str_zip, str_addr1, 
   str_addr2, str_tel, str_handtel, 
   str_email, str_memo,str_st
 
 from tab_organ_order where 
 num_step > 0 $whereadd 

 order by num_step desc 

";
$row = $DB -> sqlFetchAll($sql);
$tpl->assign(array('LIST'=>$row));




$tpl = &WebApp::singleton('Display');

$tpl->assign(array(
	'CATE_LIST'	=>	$data,
	'ccode'		=>	$ccode,
	'varname'	=>	$varname,
    'hname'     =>  $hname,
	'required'	=>	$param['required']
));
$tpl->print_("CATE_SELECT");
?>