<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: namespace/wa/toolbar.php
* �ۼ���: 2005-07-07
* �ۼ���: ��ģ����
* ��  ��: ���� ����
*****************************************************************
* 
*/
$ret = "<script type='text/javascript'>WebApp.Import('ieemu.js');</script>";
$ret.= "<script type='text/javascript'>WebApp.Import('cb2.js');</script>";
$ret.= "<script type='text/javascript'>WebApp.ImportCSS('cb2.css');</script>\n";
return $ret.'<div class="toolbar" style="background-color:ThreedFace">'.customtag($innerHTML,$GLOBALS['tpl']).'</div>';
?>
