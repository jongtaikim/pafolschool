<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: namespace/wa/editor.php
* �ۼ���: 2005-07-07
* �ۼ���: ��ģ����
* ��  ��: dhtml ������ ���
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