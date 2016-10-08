<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-04-17
* 작성자: 김종태
* 설  명: 카운터 보이기
*****************************************************************
* 
*/
set_time_limit(0);
@header("pragma: no-cache");
@header("Cache-Control: no-store, no-cache, must-revalidate"); 

$cache_file = 'hosts/'.HOST.'/inc.party.htm';

//2008-04-17 종태 
// 임시 html 체크
$tem_hrml = _DOC_ROOT.'/theme/'._THEME.'/attach/attach.party_no.htm';

if(!is_file($tem_hrml) && date('Ymd') > date('Ymd',filemtime($tem_hrml))) {
	//2008-04-17 종태 디자인라이브러리 방식	
	$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
	$fp = file_get_contents(_DOC_ROOT."/theme/"._THEME."/attach/attach.party.htm");// 파일지정하고
	$fp = str_replace('<wa:applet module="party.main_view">',"",$fp); //네임어플 테그 제거하고
	$fp = str_replace('</wa:applet>',"",$fp);
	$FTP->put_string($fp, $tem_hrml); //그걸 _no 붙여 저장	
}




if (!is_file($cache_file) && date('Ymd') > date('Ymd',filemtime($cache_file))) {
	
	//2008-04-17 종태 라이브러리를 위해서
	$theme_name = _PARTY;
	$template = $param['template'];
    if ($theme_name) $template = "/theme/".$theme_name."/attach/attach.party_no.htm";

	$tpl->define('PARTY_',$template);
	
	$content = $tpl->fetch('PARTY_'.$type);
	$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
	$FTP->put_string($content, _DOC_ROOT.'/'.$cache_file);
	

    echo $content;
} else {
    echo file_get_contents($cache_file);
}
usleep(400);
flush();
?>
