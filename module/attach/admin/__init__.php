<?
include_once "module/admin/__init__.php";
$tpl = &WebApp::singleton('Display');
if(!$editor) $editor = "tniy";
$tpl->assign(array('editor'=>$editor));
?>