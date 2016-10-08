<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: main.php
* 작성일: 2008-05-22
* 작성자: 김종태
* 설  명: 사이트 메인
*****************************************************************
* 
*/
$tpl->setLayout('@main');


$tpl->define('CONTENT', Display::getTemplate('main.htm'));
$tpl->assign('MAIN_CONF',Display::getMainConf());

//슈퍼 레이저 카운터 2008-11-27 종태
//////////////////////////////////////////////////////////////////////////////////////////////////

$rrref = str_replace("www.","",$_SERVER[HTTP_REFERER]);
$rrref = str_replace("WWW.","",$rrref);
$hhosr = str_replace("www.","",$_SERVER[HTTP_HOST]);
$hhosr = str_replace("WWW.","",$hhosr);
$hhosr_r = explode(".",$hhosr);
$hhosr = $hhosr_r[0];

if(strstr($rrref,"naver")) $str_re_name = "네이버";
if(strstr($rrref,"blog.naver")) $str_re_name = "네이버 블로그";
if(strstr($rrref,"cafe.naver")) $str_re_name = "네이버 카페";
if(strstr($rrref,"search.naver")) $str_re_name = "네이버 검색";
if(strstr($rrref,"web.search.naver")) $str_re_name = "네이버 웹문서 검색";
if(strstr($rrref,"mail2.naver")) $str_re_name = "네이버메일";
if(strstr($rrref,"kin.naver")) $str_re_name = "네이버지식인";


if(strstr($rrref,"search.live")) $str_re_name = "MSN LIVE 검색";

if(strstr($rrref,"daum")) $str_re_name = "다음";
if(strstr($rrref,"daum") || strstr($rrref,"cafe")) $str_re_name = "다음카페";

if(strstr($rrref,"search.daum")) $str_re_name = "다음검색";
if(strstr($rrref,"emaps")) $str_re_name = "엠파스";
if(strstr($rrref,"search.emaps")) $str_re_name = "엠파스열린검색";
if(strstr($rrref,"google")) $str_re_name = "구글";

if(strstr($rrref,"cyworld")) $str_re_name = "싸이월드";
if(strstr($rrref,"minihp.cyworld")) $str_re_name = "싸이월드미니홈피";
if(strstr($rrref,"club.cyworld")) $str_re_name = "싸이월드클럽";


if(strstr($rrref,"paran")) $str_re_name = "파란";
if(strstr($rrref,"yahoo")) $str_re_name = "야후";
if(strstr($rrref,"kr.search.yahoo")) $str_re_name = "야후검색";
if(strstr($rrref,"kr.dir.yahoo")) $str_re_name = "야후디렉토리검색";

if(!$rrref) {
	$rrref = "BOOKMARK";
	$str_re_name = "일반접근";
}

if(!$_SESSION[_COUNT]){
	$DB = &WebApp::singleton('DB');
	//1달전 기록은 지운다
	$mkMs = mktime(0,0,0,date("m"),1,date("Y"));
	//$sql = "delete from TAB_IP_COUNTER where num_oid = $_OID and num_date < ".$mkMs." ";
	//$DB->query($sql);
	//$DB->commit();


		$mks = mktime(0,0,0,date("m"),date("d"),date("Y"));
		$mke = mktime(23,59,59,date("m"),date("d"),date("Y"));

		$sql = "select count(*) from TAB_IP_COUNTER where num_oid = $_OID and num_date >= $mks and num_date <= $mke  and str_ip = '".$_SERVER[REMOTE_ADDR]."' ";
		//echo $sql;
		$totalcount = $DB -> sqlFetchOne($sql);

		if($totalcount < 1) {
		$sql = "INSERT INTO ".TAB_IP_COUNTER." 
				(
				num_oid,
				str_ip,
				num_date,
				str_http_referer,
				str_host,
				str_re_name
				
				) VALUES (
						
				$_OID,
				'".$_SERVER[REMOTE_ADDR]."',
				".mktime().",
				'".$rrref."',
				'".$hhosr."',
				'$str_re_name'

				) ";

				$DB->query($sql);
				$DB->commit();	

			$cache_file = _DOC_ROOT.'/hosts/'.HOST.'/inc.counter.htm';
			if($cache_file){
			$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
			$FTP->delete($cache_file);
			}
		$_SESSION[_COUNT] = "y";
		}

		
}
//////////////////////////////////////////////////////////////////////////////////////////////////
//슈퍼 레이저 카운터 끝 2008-11-27 종태



?>
