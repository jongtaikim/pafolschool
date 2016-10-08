<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: namespace/wa/datepicker.php
* 작성일: 2005-07-08
* 작성자: 거친마루
* 설  명: 날짜 선택 입력박스
*****************************************************************
* 
*/
if (!$attr['theme']) $attr['theme'] = 'tas';
if (!$attr['format']) $attr['format'] = '%Y-%m-%d';
if (!$attr['lang']) {
	$attr['lang'] = WebApp::getConf('site.language'); //'ko' or 'ko_KR.eucKR';
    if (strpos($attr['lang'],'_') !== false) $attr['lang'] = substr($attr['lang'],0,strpos($attr['lang'],'_'));
}
$ret = '';
if(!defined('WA_DATEPICKER_LOADED')) {
    $ret = '<script type="text/javascript" src="util/jscalendar/calendar_stripped.js"></script>
<script type="text/javascript" src="util/jscalendar/calendar-setup_stripped.js"></script>
<script type="text/javascript" src="util/jscalendar/lang/calendar-'.$attr['lang'].'.js"></script>';
    define('WA_DATEPICKER_LOADED',true);
}
$ret .=  '<style type="text/css">@import url(util/jscalendar/css/calendar-'.$attr['theme'].'.css);</style>
<input type="text" size="12" name="'.$attr['name'].'" id="'.$attr['name'].'" value="'.$attr['value'].'" '.($attr['readonly'] ? 'readonly ': '').'/><img src="image/icon/datepicker.gif" id="datepicker-'.$attr['name'].'" align="absmiddle" style="cursor:pointer">
<script type="text/javascript">
Calendar.setup({"inputField":"'.$attr['name'].'", "button":"datepicker-'.$attr['name'].'","ifFormat":"'.$attr['format'].'","weekNumbers":false,"singleClick":true});
</script>';
return $ret;
?>
