<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2009-01-15
* �ۼ���: ������
* ��   ��: �����⺻����
*****************************************************************
* 
*/
$mou_name =  $key;

$tpl = &WebApp::singleton('Display');
$conf_main =  WebApp::getThemeConf($mou_name);
$conf =  WebApp::getThemeConf($r_layout.'_'.$mou_name);

include $_SERVER["DOCUMENT_ROOT"].'/module/lib.php';
$conf[skin] = $theme;

$tpl->assign($conf);
$tpl->assign($conf_main);

	//2008-04-17 ���� ���̺귯���� ���ؼ�
	if(is_file(_DOC_ROOT."/object/".$mou_name."/".$conf[skin].".html")) {
	$template = "/object/".$mou_name."/".$conf[skin].".html";		
	}else{
	$template = "/object/".$mou_name."/object.html";
	}

	$tpl->define($mou_name.'_W_',$template);


	include 'module.php';


	$content = $tpl->fetch($mou_name.'_W_');
	

	

    echo $content;
	echo "|||".$mou_name;

?>
