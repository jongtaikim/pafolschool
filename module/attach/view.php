<script language="JavaScript">
<!--
var ifrContentsTimer;
function resizeRetry() { //�̹������� �ε��ð��� �ɸ��� �͵��� �ε����� �ٽ� �ѹ� ��������
        if(document.body.readyState == "complete") { 
            clearInterval(ifrContentsTimer); 
        }else { 
            resizeFrame(); 
        } 
} 
function resizeFrame(){  //�������� �ε��Ǹ� �ٷ� ��������..
        var h = parseInt(document.body.scrollHeight);
         var w = parseInt(document.body.scrollWidth)+18; 
	self.resizeTo(w, h); 


} 
//-->
</script>
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

$sql = "select  * from TAB_ATTACH_CONFIG where NUM_OID = "._OID." and STR_NAME = '$name' and str_layout='main' ";
$setup = $DB -> sqlFetch($sql);
if(!$setup) {
$sql = "select  * from TAB_ATTACH_CONFIG where NUM_OID = "._OID." and STR_NAME = '$name' and str_layout='sub' ";
$setup = $DB -> sqlFetch($sql);
}
	$mk = mktime();
    $tpl = &WebApp::singleton('Display');
	

	//2008-04-17 ���� ���̺귯���� ���ؼ�
	$template = Display::getTemplate($filepath);

	$tpl->define('Tmp_'.$mk,$template);

	$content = $tpl->fetch('Tmp_'.$mk);

	//2008-05-22 ���� css ��������
	$sql = "select STR_LAYOUT from TAB_CSS where num_oid = $_OID and num_serial = $_CSS ";
	$css = $DB -> sqlFetchOne($sql);
	$total_css = $css;


?>

<link rel="stylesheet" type="text/css" href="/css/admin.css">
<link rel="stylesheet" type="text/css" href="/theme/<?=_THEME?>/css/main.css">

<? if(!$setup['str_width']) { ?>

<body onload="resizeFrame();ifrContentsTimer = setInterval('resizeRetry()',100);" style="margin:0" bgcolor="#FFFFFF" >
<? }else{ ?>
<body onload="resizeTo(<?=$setup['str_width']*2+30?>, <?=$setup['str_height']*2+10?>);">
<? 	}
if($setup['str_width'] < 50) {
	$setup['str_width'] = 60;
}

?>
<div style="width:<?=$setup['str_width']*2+10?>">
<?="<style>".$total_css."</style>".$content?>
</div>
</body>



<?
	 break;
	case "POST":
	 
	break;
	}

?>