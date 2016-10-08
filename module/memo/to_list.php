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
if(!$save) $save="N";

$sql = "select count(*) from TAB_MEMO where num_oid = $_OID and str_to_id = '".$_SESSION[USERID]."' and str_save='".$save."'";
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
    STR_SEND_DATE, STR_READING_DATE,
	STR_SEND_NAME, STR_SEND_NICK

	from TAB_MEMO where num_oid = $_OID and str_to_id = '".$_SESSION[USERID]."' and str_to_del='N' and str_save='".$save."'
	order by num_serial desc

	)b)a
                where a.RNUM >=  $seek and a.RNUM <= $offset ";

	$row = $DB -> sqlFetchAll($sql);
	$tpl->assign(array('LIST'=>$row));
	


	$tpl->setLayout('admin');
	$tpl->define("CONTENT", Display::getTemplate("memo/to_list.htm"));

	$tpl->assign(array(
	'title'=>$title,
	'page'=>$page,
	'total'=>$total,
	'save'=>$save,
	));

	
	 break;
	case "POST":
		switch ($mode) {
			case "delete":
				
				for($a=0 ; $a<sizeof($serials) ; $a++){
					if(!$serials[$a]) continue;

					$sql = "UPDATE TAB_MEMO SET str_to_del='Y' WHERE num_oid=$_OID and str_to_id='".$_SESSION[USERID]."' and num_serial=$serials[$a]";
					$DB->query($sql);
					$DB->commit();
				}

				WebApp::moveBack('삭제했습니다.');

			break;
			case "save":

				for($a=0 ; $a<sizeof($serials) ; $a++){
					if(!$serials[$a]) continue;

					$sql = "UPDATE TAB_MEMO SET str_save='Y' WHERE num_oid=$_OID and str_to_id='".$_SESSION[USERID]."' and num_serial=$serials[$a]";
					$DB->query($sql);
					$DB->commit();
				}

				WebApp::moveBack('쪽지를 보관함으로 옮겼습니다.');

			break;

		}

	 break;
	}

?>