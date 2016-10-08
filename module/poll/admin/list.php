<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/poll/admin/list.php
* 작성일: 2005-03-24
* 작성자: 이범민
* 설  명: 
*****************************************************************
* 
*/
$DB = &WebApp::singleton("DB");
if(!$page) $page = 1;
$listnum = 10;
$offset = ($page-1) * $listnum;

$sql = "SELECT COUNT(*) FROM ".TAB_POLL_MAIN." WHERE NUM_OID=$_OID AND STR_SECT='$sect'";
$total = $DB->sqlFetchOne($sql);
if(!$total) $total = 0;


$page = $_REQUEST['page'];
if (!$page) $page = 1;

$seek = $listnum * ($page - 1);
$offset = $seek + $listnum;


$sql = "
			SELECT 
				*
			FROM ".TAB_POLL_MAIN."
			WHERE
				NUM_OID=$_OID AND
				STR_SECT='$sect' limit  $seek , $listnum";


if($data = $DB->sqlFetchAll($sql)) array_walk($data,'list_format');


$tpl->define("CONTENT","html/poll/admin/list.htm");
$tpl->assign(array(
	'LIST'=>$data,
	'total'=>$total,
	'listnum'=>$listnum
));

function list_format(&$arr) {
	global $URL,$total,$listnum,$page;
	static $num;
	$arr['num'] = $total - (($page-1) * $listnum) - $num++;
	$arr['modifylink'] = $URL->setVar(array('act'=>'.write','id'=>$arr['num_serial']));
	$arr['dt_start_date'] = date("Y-m-d",$arr['dt_start_date']);
	$arr['dt_finish_date'] = date("Y-m-d",$arr['dt_finish_date']);

}
?>