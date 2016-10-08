<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: namespace/wa/tool-button.php
* 작성일: 2005-07-07
* 작성자: 거친마루
* 설  명: 툴바 버튼  (experimental)
*****************************************************************
* 
*/

if ($attr['text'] != null && $innerHTML == null) {
	$text = $attr['text'];
} else {
	$text = $innerHTML;
}
if ($attr['icon']) $text = '<img src="'.$attr['icon'].'" align="absmiddle" border="0" />'.$text;
if (!$attr['id']) $attr['id'] = 'btn_'.rand(10000,99999);
$btnsrc = '<button id="'.$attr['id'].'" class="coolButton" tabIndex="1" onfocus="blur()">'.$text.'</button>';
$btnsrc.= '<script type="text/javascript">createButton(document.getElementById("'.$attr['id'].'"));</script>';
return $btnsrc;
?>
