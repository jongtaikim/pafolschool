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


$sql = "SELECT COUNT(*) FROM ".TAB_MAIN_BOARD." WHERE NUM_OID=1";
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
$tpl->define("CONTENT", Display::getTemplate("new_admin/list.htm"));


// 아이피 체크 2007-06-21 종태
# (회사 IP인지 체크)

    $REMOTE_ADDR;
    if(!$REMOTE_ADDR) $REMOTE_ADDR = getenv('REMOTE_ADDR');

	$except = array('1');
	$ipbase = substr($REMOTE_ADDR,0,strrpos($REMOTE_ADDR,'.'));
	$iptail = substr($REMOTE_ADDR,strrpos($REMOTE_ADDR,'.')+1);
	//if ($ipbase == '125.7.178' && ($iptail >= 1 && $iptail <= 50)) return (!in_array($iptail,$except));
	if (
  ($ipbase == '218.37.40' && ($iptail >= 1 && $iptail <= 100))
  or($ipbase == '211.233.162' && ($iptail >= 1 && $iptail <= 255))
  or($ipbase == '125.7.183' && ($iptail >= 1 && $iptail <= 255))
  or($ipbase == '124.199.149' && ($iptail >= 1 && $iptail <= 255))
  or($ipbase == '211.214.160' && ($iptail >= 1 && $iptail <= 255))
  or($ipbase == '218.37.42' && ($iptail >= 1 && $iptail <= 255))
  
	) 
	{ $tpl->assign(array('hidden_s'=> "",'hidden_e'=> "",)); }else{   $tpl->assign(array('hidden_s'=> "<!--",'hidden_e'=> "-->",));	}



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
	$arr['viewlink'] = $URL->setVar(array('act'=>'.view','code'=>trim($arr['str_code']),'id'=>$arr['num_serial']));
	
	$mk = mktime() - 86400;
	$mk = date("Y-m-d",$mk);
	$mk2 = date("Y-m-d");
	
	
	
	if($arr['dt_date'] == $mk or $arr['dt_date'] == $mk2  ) {
	$arr['img'] = "<img src = /image/icon/new2.gif>";
	}
}
?>
