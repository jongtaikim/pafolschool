<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: list.php
* �ۼ���: 
* �ۼ���: �̹���
* ��  ��: 
*****************************************************************
* 
*/
//2008-05-07 �޴��� ��ϵ� �κ��� ������� �ش� �Ŵ��������� �̵� ����
if(!$mcode) {
$DB = &WebApp::singleton("DB");
$sql = "select num_mcode from TAB_MENU where num_oid = '$_OID' and str_type = 'link#poll' ";
$mcode_meta = $DB -> sqlFetchOne($sql);	
if($mcode_meta) {
if(strstr($REQUEST_URI,"?")){
echo "<meta http-equiv='Refresh' Content=\"0; URL='".$REQUEST_URI."&mcode=$mcode_meta'\">";
}else{
echo "<meta http-equiv='Refresh' Content=\"0; URL='".$REQUEST_URI."?mcode=$mcode_meta'\">";
}
exit;
}
}

$DB = &WebApp::singleton("DB");
if(!$page = $_REQUEST['page']) $page = 1;
$listnum = 10;
$offset = ($page-1) * $listnum;

if($type) $where = " and str_type='$type'";
$sql = "SELECT COUNT(*) FROM ".TAB_POLL_MAIN." WHERE NUM_OID=$_OID AND STR_SECT='$sect'";
if(!$total = $DB->sqlFetchOne($sql)) $total = 0;



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

$tpl->setLayout('@sub');
$tpl->define("CONTENT","html/poll/skin/$skin/list.htm");
$tpl->assign(array(
	'sect'=>$sect,
	'total' => $total,
	'page' => $page,
	'listnum' => $listnum,
	'LIST' => $data
));

function list_format(&$arr) {
	global $URL,$total,$offset;
	static $num;
	$arr['num'] = $total - $offset - $num++;
	$arr['readlink'] = $URL->setVar(array('act'=>'.view','page'=>'','id'=>$arr['num_serial']));
	$today = mktime();
	if($arr['dt_finish_date']<$today) $arr['state'] = '��������';
	elseif($arr['dt_start_date']<=$today) $arr['state'] = '<span class="on">������</span>';
	else $arr['state'] = '<font color="blue">��������</font>';
}
?>