<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: namespace/wa/timestamp.php
* �ۼ���: 2005-07-05
* �ۼ���: ��ģ����
* ��  ��: ���� �ð� ���
*****************************************************************
* 
*/
$time = date('U');
if ($attr['time'])$time = $attr['time'];
if ($attr['format']) $format = $attr['format'];
if (!$format) $format = 'Y-m-d';
switch (strtolower($format)) {
	case 'long':
        return date('Y�� m�� d�� H�� i�� s��',$time);
    case 'short':
        return date('Y-m-d H:i:s',$time);
    default:
        return date($format,$time);
}
?>
