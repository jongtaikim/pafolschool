<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: function.debug_var.php
* �ۼ���: 2005-01-12
* �ۼ���: ��ģ����
* ��  ��: ������ ������ϱ�
*****************************************************************
* 
*/

function debug_var($arr) {
	if (!is_array($arr) && !is_object($arr)) return '<script>WebApp.ImportCSS("proptable.css");</script><table border width="100%" class="proptable"><tr><td>'.$arr.'</td></tr></table>';
	if (!count($arr) || $arr == '') return '[Empty Array]';
	$ret = '<script>WebApp.ImportCSS("proptable.css");</script><table border width="100%" class="proptable">';
	foreach ($arr as $key=>$value) {
		$ret.= '<tr><th width="20" nowrap>'.$key.'</th><td>';
		$ret.= (is_array($value) || is_object($value)) ? debug_var($value) : $value;
	}
	$ret.= '</td></tr></table>';
	return $ret;
}
?>