<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/attach/view_part.php
* 작성일: 2008-06-12
* 작성자: 김종태
* 설  명: 레이아웃 컨텐츠 에디터
*****************************************************************
* 
*/


switch ($REQUEST_METHOD) {
	case "GET":
	


$DB = &WebApp::singleton("DB");
$tpl = &WebApp::singleton('Display');
$FH = &WebApp::singleton('FileHost','main','part');

$ATT_CONF = Display::getAttachConf();
/*echo "<xmp>";
print_r($ATT_CONF);
exit;*/
$filepath = array_pop($ATT_CONF[$name]['file']);


	if(!$layout) $layout = "main";

	$mk = mktime();

	

	//2008-04-17 종태 라이브러리를 위해서
	$template = file_get_contents(Display::getTemplate($filepath));// 파일지정하고Display::getTemplate($filepath);

//	$tpl->define('Tmp_'.$mk,$template);

	$content = $template;

$sql = "select str_width,str_height from TAB_ATTACH_CONFIG 

where NUM_OID = '$_OID' and  STR_LAYOUT = '$layout' and STR_NAME = '$name'  ";
$row = $DB -> sqlFetch($sql);

$tpl->assign(array('width'=>$row[str_width] *2 +5,'height'=>$row[str_height] *2 +5));



	$tpl->setLayout('admin');
	$tpl->assign(array('content'=>$content,'LIST'=>$ATT_CONF,'name'=>$name,'layout'=>$layout));
	
	
	$tpl->define("CONTENT", Display::getTemplate("attach/view_edit.htm"));
	
	 break;
	
	
	case "POST":
	 break;

	}
?>