<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* : module/news/admin/list.php
* : 2005-03-22
* : 
*   : 
*****************************************************************
* 
*/
$DB = &WebApp::singleton("DB");
$code = $_REQUEST['code'];
if(!$page = $_REQUEST['page']) $page = 1;

if(!$listnum)$listnum = 10;

$sql = "SELECT COUNT(*) FROM ".TAB_MAIN_BOARD." WHERE NUM_OID=$_OID and str_code='$code' ";
$total = $DB->sqlFetchOne($sql);
if(!$total) $total = 0;


$page = $_REQUEST['page'];
if (!$page) $page = 1;

$seek = $listnum * ($page - 1);
$offset = $seek + $listnum;



$sql = "SELECT 
			
				STR_CODE,
				NUM_SERIAL,
				STR_TITLE,
				DT_DATE,
				NUM_HIT,
				STR_THUMB
			FROM ".TAB_MAIN_BOARD."
			WHERE
                num_oid=$_OID and str_code='$code' order by num_serial desc limit  $seek, $listnum";




if($data = $DB->sqlFetchAll($sql)) array_walk($data,'list_format');





$tpl->define("CONTENT", Display::getTemplate("news/admin/list.htm"));

$tpl->assign(array(
'title'=>$title,
'LIST'=>$data,
'page'=>$page,
'total'=>$total,
'listnum'=>$listnum,
'itemPerPage'=>$itemPerPage,
'a'=>$a,
'code'=>$code,

));





function list_format(&$arr) {
	global $URL;
	$arr['modifylink'] = $URL->setVar(array('act'=>'.write','code'=>trim($arr['str_code']),'id'=>$arr['num_serial']));
}
?>
