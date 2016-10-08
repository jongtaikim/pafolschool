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

$ATT_CONF = Display::getAttachConf();
//echo "<xmp>";
//print_r($ATT_CONF);
$filepath = array_pop($ATT_CONF[$name]['file']);

	

	$mk = mktime();
    $tpl = &WebApp::singleton('Display');
	

	//2008-04-17 종태 라이브러리를 위해서
	$template = Display::getTemplate($filepath);

	$tpl->define('Tmp_'.$mk,$template);

	$content = $tpl->fetch('Tmp_'.$mk);

	//2008-05-22 종태 css 가져오기
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