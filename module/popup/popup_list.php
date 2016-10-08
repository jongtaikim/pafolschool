<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: module/popup/popup_list.php
* �ۼ���: 2008-11-26
* �ۼ���: ������
* ��  ��:  ��Ʈ��� ���� �˾�������
*****************************************************************
* 
TAB_POPUP.CHR_OPEN ���հ���key 
Y,N:����Ʈ���θ���Ʈ�˾�(Y:����Ʈ�˾����-CHR_TOP_OPEN=N�ΰ͸����, N:����Ʈ�˾����������)
A,X:���հ����ڸ����˾�(A:�˾����, X:�˾����������)
B,X:����Ʈ���ΰ������˾�(B:����Ʈ�˾����, X:����Ʈ�˾����������)
TAB_POPUP.CHR_TOP_OPEN - Y: CHR_OPEN ������� ����ǥ��

*/

$DOC_TITLE = "str:�����˾�����";

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