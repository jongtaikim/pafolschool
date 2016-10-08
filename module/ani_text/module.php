<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-11-12
* 작성자: 김종태
* 설  명: main.php 표준 파일
*****************************************************************
* 
*/

$cache_file = _DOC_ROOT.'/hosts/'.HOST.'/'."inc.main.ani_text.htm";
if($del =="y") unlink($cache_file);
if(!is_file($cache_file) || date('Ymd H') > date('Ymd H',filemtime($cache_file))) {




$DB = &WebApp::singleton("DB"); //디비클래스
$URL = &WebApp::singleton('WebAppURL'); //URL 클래스
$tpl = &WebApp::singleton('Display'); //템플릿엔진 클래스
$mcode = $param['code'];  //<wa:모듈 code="{mcode}"> wa테그에서 변수 넣은값 $mcode


	$sql = "select num_serial, str_text, num_view, str_url from TAB_ANI_TEXT where num_oid="._OID." and num_view='Y' order by num_step";
	$data = $DB -> sqlFetchAll($sql);

	$tpl->assign(array(
	'LIST'=>$data,

	));





$make = "y";
} else {
	$fp = fopen($cache_file,'r');
	$content = fread($fp,filesize($cache_file));
	fclose($fp);
}

?>