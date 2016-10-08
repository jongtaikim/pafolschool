<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-11-12
* 작성자: 김종태
* 설  명: main.php 표준 파일
*****************************************************************
* 
*/
$cache_file = _DOC_ROOT.'/hosts/'.HOST.'/'."inc.main.qmenu.htm";
unlink($cache_file);
if(!is_file($cache_file) || date('Ymd H') > date('Ymd H',filemtime($cache_file))) {





$DB = &WebApp::singleton("DB"); //디비클래스



$sql = "select * from TAB_QMENU where num_oid = "._OID." order by num_step asc";
$row = $DB -> sqlFetchAll($sql);

		if(count($row)<1) { //기본값이 없을시 생성

		$sql = "INSERT INTO ".TAB_QMENU." (
		 num_oid, num_serial, str_text, str_text2, num_view, str_url, num_step
		 ) VALUES (
		 "._OID.", 1, '학급홈피','Class hompy', 'Y', '/class.list', 1) ";
		$DB->query($sql);

		$sql = "INSERT INTO ".TAB_QMENU." (
		 num_oid, num_serial, str_text, str_text2, num_view, str_url, num_step
		 ) VALUES (
		 "._OID.", 2, '온라인교무실', 'Teachers`room','Y', 'javascript:intranet_url();', 2) ";
		$DB->query($sql);
		 
		 $sql = "INSERT INTO ".TAB_QMENU." (
		 num_oid, num_serial, str_text, str_text2, num_view, str_url, num_step
		 ) VALUES (
		 "._OID.", 3, '동아리', 'Club', 'Y','/party.list', 3) ";
		$DB->query($sql);

		 $sql = "INSERT INTO ".TAB_QMENU." (
		 num_oid, num_serial, str_text, str_text2, num_view, str_url, num_step
		 ) VALUES (
		 "._OID.", 4, '스쿨잼', 'SchoolZam','Y', 'http://www.schoolzem.com/', 4) ";
		$DB->query($sql);

		 $sql = "INSERT INTO ".TAB_QMENU." (
		 num_oid, num_serial, str_text, str_text2, num_view, str_url, num_step
		 ) VALUES (
		 "._OID.", 5, '전자도서관','Digital library', 'Y', '#', 5) ";
		$DB->query($sql);

		$DB->commit();

		$sql = "select * from TAB_QMENU where num_oid = "._OID." order by num_step asc ";
		$row = $DB -> sqlFetchAll($sql);
	
		}

$tpl->assign(array('tqmenu_LIST'=>$row));


$make = "y";
} else {
	$fp = fopen($cache_file,'r');
	$content = fread($fp,filesize($cache_file));
	fclose($fp);
}


?>