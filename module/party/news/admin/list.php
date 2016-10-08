<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/party/news/admin/list.php
* 작성일: 2006-05-17
* 작성자: 이범민
* 설  명: 
*****************************************************************
* 
*/

$DB = &WebApp::singleton("DB");
if(!$page = $_REQUEST['page']) $page = 1;
$itemPerPage = 10;

$sql = "SELECT COUNT(*) FROM ".TAB_PARTY_MAIN_BOARD." WHERE num_oid=$_OID AND num_pcode=$pcode";
$total = $DB->sqlFetchOne($sql);
if(!$total) $total = 0;
$PG = &WebApp::singleton('Paging',$total);
$dummy = $PG->__toString();
$offset = $PG->getOffset();

$sql = "SELECT * FROM (
			SELECT 
				/*+ INDEX_DESC(".TAB_PARTY_MAIN_BOARD." ".PK_TAB_PARTY_MAIN_BOARD.") */
				ROWNUM AS rnum,
				NUM_SERIAL,
				STR_TITLE,
				TO_CHAR(DT_DATE,'YYYY-MM-DD') DT_DATE,
				NUM_HIT
			FROM ".TAB_PARTY_MAIN_BOARD."
			WHERE
                num_oid=$_OID AND
                num_pcode=$pcode AND
				rownum<=$itemPerPage
		) WHERE rnum>$offset";
if($data = $DB->sqlFetchAll($sql)) array_walk($data,'list_format');
$tpl->setLayout('admin');
$tpl->define("CONTENT", Display::getTemplate("party/news/admin/list.htm"));
$tpl->assign(array(
'title'=>$title,
'LIST'=>$data,
'page'=>$page,
'total'=>$total,
'itemPerPage'=>$itemPerPage
));

function list_format(&$arr) {
	global $URL;
	$arr['modifylink'] = $URL->setVar(array('act'=>'.write','code'=>trim($arr['num_pcode']),'id'=>$arr['num_serial']));
}
?>
