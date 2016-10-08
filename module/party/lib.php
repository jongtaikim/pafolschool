<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-04-17
* 작성자: 김종태
* 설  명: 카운터 라이브러리파일
*****************************************************************
* 
*/

$cache_file = 'hosts/'.HOST.'/inc.party.htm';
$tpl = &WebApp::singleton('Display');

 $FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
 $FTP->delete(_DOC_ROOT.'/'.$cache_file);

 	
//2008-04-17 종태 디자인라이브러리 방식	
	//$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
	$fp = file_get_contents(_DOC_ROOT."/theme/".$theme."/attach/attach.party.htm");// 파일지정하고
	$fp = str_replace('<wa:applet module="party.main_view">',"",$fp); //네임어플 테그 제거하고
	$fp = str_replace('</wa:applet>',"",$fp);
	$FTP->put_string($fp, _DOC_ROOT.'/theme/'.$theme.'/attach/attach.party_no.htm'); //그걸 _no 붙여 저장
////////////////////////////// 기존 출력파일은 반드시 케시할것


	//2008-04-17 종태 라이브러리를 위해서
	$template = "/theme/".$theme."/attach/attach.party_no.htm";

	$tpl->define('PARTY_',$template);
	

	$content = $tpl->fetch('PARTY_'.$type);
	$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
	$FTP->put_string($content, _DOC_ROOT.'/'.$cache_file);


    echo $content;
	echo "|||party";

?>
