<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: namespace/wa/timestamp.php
* 작성일: 2005-07-05
* 작성자: 거친마루
* 설  명: 현재 시간 출력
*****************************************************************
* 
*/
$time = date('U');
if ($attr['time'])$time = $attr['time'];
if ($attr['format']) $format = $attr['format'];
if (!$format) $format = 'Y-m-d';
switch (strtolower($format)) {
	case 'long':
        return date('Y년 m월 d일 H시 i분 s초',$time);
    case 'short':
        return date('Y-m-d H:i:s',$time);
    default:
        return date($format,$time);
}
?>
