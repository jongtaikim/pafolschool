<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2008-04-17
* �ۼ���: ������
* ��  ��: ī���� ���̺귯������
*****************************************************************
* 
*/

$cache_file = 'hosts/'.HOST.'/inc.party.htm';
$tpl = &WebApp::singleton('Display');

 $FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
 $FTP->delete(_DOC_ROOT.'/'.$cache_file);

 	
//2008-04-17 ���� �����ζ��̺귯�� ���	
	//$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
	$fp = file_get_contents(_DOC_ROOT."/theme/".$theme."/attach/attach.party.htm");// ���������ϰ�
	$fp = str_replace('<wa:applet module="party.main_view">',"",$fp); //���Ӿ��� �ױ� �����ϰ�
	$fp = str_replace('</wa:applet>',"",$fp);
	$FTP->put_string($fp, _DOC_ROOT.'/theme/'.$theme.'/attach/attach.party_no.htm'); //�װ� _no �ٿ� ����
////////////////////////////// ���� ��������� �ݵ�� �ɽ��Ұ�


	//2008-04-17 ���� ���̺귯���� ���ؼ�
	$template = "/theme/".$theme."/attach/attach.party_no.htm";

	$tpl->define('PARTY_',$template);
	

	$content = $tpl->fetch('PARTY_'.$type);
	$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
	$FTP->put_string($content, _DOC_ROOT.'/'.$cache_file);


    echo $content;
	echo "|||party";

?>
