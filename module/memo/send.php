<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-11-24
* 설   명: 쪽지보내기
*****************************************************************
* 
*/
function loginChk(){
if(!$_SESSION[USERID]) {
	echo '<script>alert("로그인이 필요합니다."); self.close();</script>';
	exit;
}
}


loginChk();
$tpl->define("MEMO_TOP", Display::getTemplate("memo/top.htm"));
	
$DB = &WebApp::singleton('DB');


switch ($REQUEST_METHOD) {
	case "GET":
	
	$tpl->setLayout('admin');
	$tpl->define("CONTENT", Display::getTemplate("memo/send.htm"));

	$tpl->assign(array('str_to_id'=>$str_to_id));
	
	
	
	 break;
	case "POST":

	$sql = "select count(str_id) from TAB_MEMBER where num_oid = $_OID  and str_id = '$str_to_id' ";
	if($DB -> sqlFetchOne($sql)){

		
		

	$sql = "select max(num_serial)+1 from TAB_MEMO where num_oid = $_OID  ";
	$max_num_serial = $DB -> sqlFetchOne($sql);

	if(!$max_num_serial) $max_num_serial  = 1;
	
	$sql = "INSERT INTO ".TAB_MEMO." (	
	
   NUM_OID, 
   STR_SEND_ID, 
   STR_TO_ID, 
   NUM_SERIAL, 
   STR_TITLE, 
   STR_TEXT, 
   STR_SEND_DATE,
   STR_SEND_NAME,
   STR_SEND_NICK


	) VALUES (

   '$_OID', 
   '".$_SESSION[USERID]."', 
   '$str_to_id', 
   $max_num_serial, 
   '$str_title', 
   '$str_text', 
   '".mktime()."',
    '".$_SESSION['NAME']."',
	'".$_SESSION['NICKNAME']."'
	
	) ";
	




	if($DB->query($sql)){
	$DB->commit();
	echo '<script>alert("발송하였습니다.");</script>';
	echo "<meta http-equiv='Refresh' Content=\"0; URL='/memo.send_list'\">";
	
	}
	}else{
	WebApp::moveBack('존재 하지 않는 아이디입니다.');
	}
	

	
	 break;
	}

?>