<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: namespace/wa/editor.php
* 작성일: 2005-07-07
* 작성자: 거친마루
* 설  명: dhtml 에디터 출력
*****************************************************************
* 
*/
$str = file_get_contents('var/_editor.htm');
if (empty($attr['sect'])) $attr['sect'] = 'menu';
if (empty($attr['upload'])) $attr['upload'] = 'true';
if (empty($attr['toolbar'])) $attr['toolbar'] = 'Default';
if (empty($attr['width'])) $attr['width'] = '100%';
if (empty($attr['height'])) $attr['height'] = '400';
$innerHTML = str_replace('http://{FILE_HOST}','http://'.$GLOBALS['FILE_HOST'],$innerHTML);
return str_replace(
	array('%sect%','%name%','%content%','%toolbar%','%width%','%height%'),
	array($attr['sect'],$attr['name'],$innerHTML,$attr['toolbar'],$attr['width'],$attr['height']),
	$str
);
?>