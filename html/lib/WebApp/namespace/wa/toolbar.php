<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: namespace/wa/toolbar.php
* 작성일: 2005-07-07
* 작성자: 거친마루
* 설  명: 툴바 생성
*****************************************************************
* 
*/
$ret = "<script type='text/javascript'>WebApp.Import('ieemu.js');</script>";
$ret.= "<script type='text/javascript'>WebApp.Import('cb2.js');</script>";
$ret.= "<script type='text/javascript'>WebApp.ImportCSS('cb2.css');</script>\n";
return $ret.'<div class="toolbar" style="background-color:ThreedFace">'.customtag($innerHTML,$GLOBALS['tpl']).'</div>';
?>
