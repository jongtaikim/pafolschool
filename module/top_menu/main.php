<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2009-01-15
* �ۼ���: ������
* ��   ��: �����⺻����
*****************************************************************
* 
*/

$tpl = &WebApp::singleton('Display');
$conf_main =  WebApp::getThemeConf($mou_name);
$conf =  WebApp::getThemeConf(_LAYOUT_R.'_'.$mou_name);
$tpl->assign($conf);
$tpl->assign($conf_main);

include $_SERVER["DOCUMENT_ROOT"].'/module/wmain.php';
	
   $make = "y";
   $template = $param['template'];
   $tpl->define($mou_name.'_W_',$template);
	


	// �ҽ� �Էºκ�


	include 'module.php';


	// �ҽ��Է³�


// �ҽ��Է³�
		if($make =="y"){
		
		$content = $tpl->fetch($mou_name.'_W_');
		/*$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
		$FTP->put_string($content,$cache_file);*/

		}
	echo $content;

?>
