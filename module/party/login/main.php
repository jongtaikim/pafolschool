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
	if(is_file(_DOC_ROOT."/object/".$mou_name."/".$conf[skin].".html")) {
	$template = "/object/".$mou_name."/".$conf[skin].".html";		
	}else{
	$template = "/object/".$mou_name."/object.html";
	}
 
   if(_LAYOUT_R =="sub") {
	$template = "/object/".$mou_name."/object_sub.html";
   	 $type_number = $type_number+0;
	 if($type_number <10) 	$type_number = "0".$type_number;
	 $conf[skin] = "type".$type_number;
	 $tpl->assign($conf);
   }
	
	if($param[skin]) {
	$conf[skin] = $param[skin];
	 $tpl->assign($conf);
	}

   $tpl->define($mou_name.'_W_',$template);
	


	// �ҽ� �Էºκ�


	include 'module.php';


	// �ҽ��Է³�



	$content = $tpl->fetch($mou_name.'_W_');
    echo $content;

?>
