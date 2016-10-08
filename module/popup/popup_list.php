<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/popup/popup_list.php
* 작성일: 2008-11-26
* 작성자: 이현민
* 설  명:  인트라넷 통합 팝업관리자
*****************************************************************
* 
TAB_POPUP.CHR_OPEN 통합관리key 
Y,N:사이트메인리스트팝업(Y:리스트팝업띄움-CHR_TOP_OPEN=N인것만띄움, N:리스트팝업띄우지않음)
A,X:통합관리자메인팝업(A:팝업띄움, X:팝업띄우지않음)
B,X:사이트메인관리자팝업(B:리스트팝업띄움, X:리스트팝업띄우지않음)
TAB_POPUP.CHR_TOP_OPEN - Y: CHR_OPEN 상관없이 개별표출

*/

$DOC_TITLE = "str:통합팝업관리";

$DB = &WebApp::singleton("DB");
if(!$page = $_REQUEST['page']) $page = 1;
$listnum = 10;
$offset = ($page-1) * $listnum;

$sql = "SELECT COUNT(*) FROM ".TAB_POPUP." WHERE NUM_OID=$_OID and chr_open in ('A','B','X')";
$total = $DB->sqlFetchOne($sql);
if(!$total) $total = 0;

$sql = "SELECT * FROM (
			SELECT 
				ROWNUM AS rnum,
				NUM_WIDTH,
				NUM_HEIGHT,
				NUM_OID,
				NUM_SERIAL,
				STR_TITLE,
				CHR_OPEN,
				CHR_TOP_OPEN,
				TO_CHAR(DT_DATE,'YY-MM-DD') DT_DATE,
				DT_START_DATE,
				DT_END_DATE
			FROM ".TAB_POPUP."
			WHERE
				ROWNUM<=$offset+$listnum AND
				NUM_OID=$_OID and chr_open in ('A','B','X')
		) WHERE rnum>$offset order by NUM_SERIAL desc ";
if($data = $DB->sqlFetchAll($sql)) array_walk($data,'list_format');

for($ii=0; $ii<count($data); $ii++) {

	$data[$ii][nnum] = $ii+1;

}


$tpl->setLayout();
//$tpl->define("CONTENT","html/popup/popup_list.htm");
$tpl->define("CONTENT", Display::getTemplate("popup/popup_list.htm"));
$tpl->assign(array(
	'listnum'=>$listnum,
	'total'=>$total,
	'LIST'=>$data,
	'a'=>$a

));

function list_format(&$arr) {
	global $total,$page,$URL;
	static $num;

	$arr['num'] = $total - (($page-1)*$listnum) - $num-- ;
	if($arr['chr_open'] == 'A') $arr['open_checked'] = 'checked';
	$arr['modifylink'] = $URL->setVar(array('act'=>'.write','id'=>$arr['num_serial']));
	
}
?>