<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2008-04-17
* �ۼ���: ������
* ��  ��: ī���� ���̱�
*****************************************************************
* 
*/
set_time_limit(0);
@header("pragma: no-cache");
@header("Cache-Control: no-store, no-cache, must-revalidate"); 

$cache_file = 'hosts/'.HOST.'/inc.party.htm';

//2008-04-17 ���� 
// �ӽ� html üũ
$tem_hrml = _DOC_ROOT.'/theme/'._THEME.'/attach/attach.party_no.htm';

if(!is_file($tem_hrml) && date('Ymd') > date('Ymd',filemtime($tem_hrml))) {
	//2008-04-17 ���� �����ζ��̺귯�� ���	
	$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
	$fp = file_get_contents(_DOC_ROOT."/theme/"._THEME."/attach/attach.party.htm");// ���������ϰ�
	$fp = str_replace('<wa:applet module="party.main_view">',"",$fp); //���Ӿ��� �ױ� �����ϰ�
	$fp = str_replace('</wa:applet>',"",$fp);
	$FTP->put_string($fp, $tem_hrml); //�װ� _no �ٿ� ����	
}




if (!is_file($cache_file) && date('Ymd') > date('Ymd',filemtime($cache_file))) {
	
	//2008-04-17 ���� ���̺귯���� ���ؼ�
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
