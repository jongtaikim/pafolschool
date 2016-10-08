<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2009-07-03
* 작성자: 김종태
* 설  명:  수쿨잼 오브젝트
*****************************************************************
* 
*/
global $organdb;

switch ($organdb[str_school]) {
	case "E":
	
	$typex = "es";
	
	 break;
	case "M":

	 $typex = "ms";
	 break;

 	case "H":

	 $typex = "hs";
	 break;
	}

$prefix =_OID - 3;

if($prefix <100) $prefix = "0".$prefix;
if($prefix <10) $prefix =  "0".$prefix;

$prefix = "sh".$prefix;

$tpl->assign(array(
'typex'=>$typex,
'prefix'=>$prefix,
));




?>
