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
	
	//2008-04-17 ���� ���̺귯���� ���ؼ�

	


	// �ҽ� �Էºκ�


	include 'module.php';


	// �ҽ��Է³�
   $template = $param['template'];



   $tpl->define($mou_name.'_W1_',$template);


	$content = $tpl->fetch($mou_name.'_W1_');
    echo $content;

?>
