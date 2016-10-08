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
$itemPerPage = 10;


$sql = "SELECT COUNT(*) FROM ".TAB_MAIN_BOARD." WHERE NUM_OID=$_OID2";
$total = $DB->sqlFetchOne($sql);
if(!$total) $total = 0;
$PG = &WebApp::singleton('Paging',$total);
$dummy = $PG->__toString();
$offset = $PG->getOffset();

$sql = "SELECT * FROM (
			SELECT 
				/*+ INDEX_DESC(".TAB_MAIN_BOARD." ".PK_TAB_MAIN_BOARD.") */
				ROWNUM AS rnum,
				STR_CODE,
				NUM_SERIAL,
				STR_TITLE,
				TO_CHAR(DT_DATE,'YYYY-MM-DD') DT_DATE,
				NUM_HIT
			FROM ".TAB_MAIN_BOARD."
			WHERE
                str_code='$code' AND
				rownum<=$offset+$itemPerPage AND
				num_oid=1
		) WHERE rnum>$offset";

if($data = $DB->sqlFetchAll($sql)) array_walk($data,'list_format');
$tpl->setLayout('admin');
$tpl->define('CONTENT', Display::getTemplate('admin/list.htm'));


$tpl->assign(array(
'title'=>$title,
'LIST'=>$data,
'page'=>$page,
'total'=>$total,
'itemPerPage'=>$itemPerPage
));

function list_format(&$arr) {
	global $URL;
	$arr['modifylink'] = $URL->setVar(array('act'=>'.write','code'=>trim($arr['str_code']),'id'=>$arr['num_serial']));
	
}
?>
