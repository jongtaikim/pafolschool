<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: module/attach/view_part.php
* �ۼ���: 2008-06-12
* �ۼ���: ������
* ��  ��: ���̾ƿ� ������ ������
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

	

	//2008-04-17 ���� ���̺귯���� ���ؼ�
	$template = file_get_contents(Display::getTemplate($filepath));// ���������ϰ�Display::getTemplate($filepath);

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