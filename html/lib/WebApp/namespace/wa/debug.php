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
$varname = preg_replace('/^\$/','_',$attr['var']);
return "{=debug_var({$varname})}";
?>

