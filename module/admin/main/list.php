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
/*
//2007-09-03 설문조사 주석처리함 종태
$sql = "select count(str_organ) from TAB_SCHOOL_POLL where str_organ = '"._ONAME."' ";
$poll_data = $DB-> sqlFetchOne($sql);

if($poll_data < 1) { */
?>

<script language="JavaScript"><!--
function win(url,mode,admin)
{
  toolbar_str = toolbar = 'no';
  menubar_str = menubar = 'no';
  statusbar_str = statusbar = 'no';
  scrollbar_str = scrollbar = 'no';
  resizable_str = resizable = 'no';

  cookie_str = document.cookie;
  cookie_str.toString();

  pos_start  = cookie_str.indexOf(name);
  pos_start  = cookie_str.indexOf('=', pos_start);
  pos_end    = cookie_str.indexOf(';', pos_start);
 



if (mode){ url = url + '?mode=' + mode; }
if (admin){ url = url + '&admin=' + admin; }



  window.open(url, 'aa', 'left=200,top=80,width=600,height=725,toolbar=no,menubar=no,status=no,scrollbars=no,resizable=no');

}

// -->
</script>
<body >
<!-- body onload = "win('school_pop.poll_popup','w','')" -->

<?
//}

if($_OID == "20182" ) {
	echo '<script>alert("샘플 사이트는 이용할 수 없습니다.");</script>';
		echo "<meta http-equiv='Refresh' Content=\"0; URL='/admin.main'\">";
exit;
}
$code = $_REQUEST['code'];
if(!$page = $_REQUEST['page']) $page = 1;
$itemPerPage = 15;


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




$tpl->setLayout('menu_nog');
$tpl->define("CONTENT", Display::getTemplate("admin/list.htm"));


// 아이피 체크 2007-06-21 종태
# (회사 IP인지 체크)

    $REMOTE_ADDR;
    if(!$REMOTE_ADDR) $REMOTE_ADDR = getenv('REMOTE_ADDR');

	$except = array('1');
	$ipbase = substr($REMOTE_ADDR,0,strrpos($REMOTE_ADDR,'.'));
	$iptail = substr($REMOTE_ADDR,strrpos($REMOTE_ADDR,'.')+1);
	//if ($ipbase == '125.7.178' && ($iptail >= 1 && $iptail <= 50)) return (!in_array($iptail,$except));

	
	if (
  ($ipbase == '61.250.141' && ($iptail >= 1 && $iptail <= 100))
  or($ipbase == '218.237.157' && ($iptail >= 1 && $iptail <= 255))
  or($ipbase == '211.104.150' && ($iptail >= 1 && $iptail <= 255))
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
