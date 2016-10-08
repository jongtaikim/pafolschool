<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/party/news/list.php
* 작성일: 2006-05-17
* 작성자: 이범민
* 설  명: 뉴스 목록/보기
*****************************************************************
* 
*/


if(!$page = $_REQUEST['page']) $page = 1;
$itemPerPage = 10;
$offset = ($page-1) * $itemPerPage;

$sql = "SELECT COUNT(*) FROM ".TAB_PARTY_MAIN_BOARD." WHERE NUM_OID=$_OID AND NUM_pcode=$pcode";
$total = $DB->sqlFetchOne($sql);
if(!$total) $total = 0;

$sql = "SELECT * FROM (
			SELECT 
				/*+ INDEX_DESC(".TAB_PARTY_MAIN_BOARD." ".PK_TAB_PARTY_MAIN_BOARD.") */
				ROWNUM AS rnum,
				NUM_SERIAL,
				STR_TITLE,
				NUM_HIT,
				TO_CHAR(DT_DATE,'YYYY-MM-DD') DT_DATE
			FROM ".TAB_PARTY_MAIN_BOARD."
			WHERE
				ROWNUM<=$offset+$itemPerPage AND
				NUM_OID=$_OID AND
				NUM_pcode=$pcode
		) WHERE rnum>$offset";
if($list = $DB->sqlFetchAll($sql)) array_walk($list,'list_format');

$DOC_TITLE = $conf['doc_title'] ? $conf['doc_title'] : 'str:'.$title;

$DOC_TITLE2 = explode(":",$DOC_TITLE);
$DOC_TITLE2 = $DOC_TITLE2[1];



$tpl->assign(array(
 
 'title_bar'=>$DOC_TITLE2,	
));

$tpl->setLayout('p');
$tpl->define("CONTENT",WebApp::getTemplate("party/news/skin/blue/list.htm"));
$tpl->assign("LIST",$list);

if($id = $_REQUEST['id']) {
	$sql = "SELECT
				STR_TITLE,
				STR_TEXT1,
				STR_TEXT2,
				STR_TEXT3,
				TO_CHAR(DT_DATE,'YYYY-MM-DD') DT_DATE,
				NUM_HIT
			FROM ".TAB_PARTY_MAIN_BOARD."
			WHERE NUM_OID=$_OID AND NUM_pcode=$pcode AND NUM_SERIAL=$id";
	if($data = $DB->sqlFetch($sql)) {
		$sql = "UPDATE ".TAB_PARTY_MAIN_BOARD." SET NUM_HIT = NUM_HIT + 1 WHERE NUM_OID=$_OID AND NUM_pcode=$pcode AND NUM_SERIAL=$id";
		$DB->query($sql);
		$DB->commit();

		$data['id'] = $id;
		$data['num_hit']++;
		$FH = &WebApp::singleton('FileHost','party',$pcode.'.news');
		$data['content'] = $FH->set_content($data['str_text1'].$data['str_text2'].$data['str_text3']);
		$data['title'] =  $data['str_title'];
		if($fdata = $FH->get_files_info($id)) {
			$total_size = array_pop($fdata);
			foreach($fdata as $frow) {
				if(eregi("(jpg|jpeg|png|gif|bmp)", $frow['str_ftype'])) {
					$preview[] = array(
						'str_upfile' => $frow['str_upfile'],
						'preview' => "<img src='".$frow['file_url']."?nocount=1' onload='if(this.width > 500) this.width=500;' border='0'>",
					);
				}
			}
			$data['FILE_LIST'] = &$fdata;
			if($preview) $data['PREVIEW_LIST'] = &$preview;
		}
	}
}
$data['pcode'] = $pcode;
$data['total'] = $total;
$data['itemPerPage'] = $itemPerPage;
$tpl->assign($data);
$URL->delVar('id');
$tpl->assign('qs',$URL->getVar());

function list_format(&$arr) {
	global $URL,$total,$page,$itemPerPage;
	static $num;
	$arr['num'] = $total - (($page-1) * $itemPerPage) - $num++;
	$arr['readlink'] = $URL->setVar(array('id'=>$arr['num_serial']));
}
?>
