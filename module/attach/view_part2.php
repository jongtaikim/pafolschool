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

$ATT_CONF = Display::getAttachConf();
//echo "<xmp>";
//print_r($ATT_CONF);
$filepath = array_pop($ATT_CONF[$name]['file']);

	

	$mk = mktime();
    $tpl = &WebApp::singleton('Display');
	

	//2008-04-17 ���� ���̺귯���� ���ؼ�
	$template = Display::getTemplate($filepath);

	$tpl->define('Tmp_'.$mk,$template);

	$content = $tpl->fetch('Tmp_'.$mk);

	//2008-05-22 ���� css ��������
	$sql = "select STR_LAYOUT from TAB_CSS where num_oid = '$_OID' and num_serial = '$_CSS' ";
	$css = $DB -> sqlFetchOne($sql);
	$total_css = $css;

?>
<FORM METHOD=POST >


<script type="text/javascript" src="/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="/module/webconfig_module_edit.js"></script>

<textarea id="%name%_board" name="content"  style="width: 500px;height:500px;"><link rel="stylesheet" type="text/css" href="/theme/<?=_THEME?>/css/main.css"><?="<style>".$total_css."</style>".$content?></textarea>


</FORM>


<?
	 break;
	case "POST":
	 
	break;
	}

?>