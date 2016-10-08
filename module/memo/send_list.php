<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-11-24
* 설   명: 보낸쪽지함
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');
function loginChk(){
if(!$_SESSION[USERID]) {
	echo '<script>alert("로그인이 필요합니다."); self.close();</script>';
	exit;
}
}


loginChk();
$tpl->define("MEMO_TOP", Display::getTemplate("memo/top.htm"));
	


switch ($REQUEST_METHOD) {
	case "GET":
	






if(!$listnum)$listnum = 10;

$sql = "select count(*) from TAB_MEMO where num_oid = $_OID and str_send_id = '".$_SESSION[USERID]."'  ";
$total = $DB -> sqlFetchOne($sql);
if(!$total) $total = 0;


$page = $_REQUEST['page'];
if (!$page) $page = 1;

$seek = $listnum * ($page - 1);
$offset = $seek + $listnum;


$sql = "
select a.* from (
         select ROWNUM as RNUM, b.* from (

	select 
	
	STR_SEND_ID, 
	STR_TO_ID, 
    NUM_SERIAL, 
	STR_TITLE,
    STR_SEND_DATE, STR_READING_DATE

	from TAB_MEMO where num_oid = $_OID and str_send_id = '".$_SESSION[USERID]."' 


	)b)a
                where a.RNUM >=  $seek and a.RNUM <= $offset ";


	$row = $DB -> sqlFetchAll($sql);
	$tpl->assign(array('LIST'=>$row));
	


	$tpl->setLayout('admin');
	$tpl->define("CONTENT", Display::getTemplate("memo/send_list.htm"));

	$tpl->assign(array(
	'title'=>$title,
	'page'=>$page,
	'total'=>$total,
	));

	
	 break;
	case "POST":
	 break;
	}

?>