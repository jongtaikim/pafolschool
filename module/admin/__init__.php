<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-10-28
* 작성자: 김종태
* 설  명:  권한별 관리자페이지 이용권한 설정
*****************************************************************
* 
*/


if($RUN_MODE == WEBAPP_RUNMODE_GLOBAL && $act !="admin.pra_view") {
    
    function check_admin_auth() {
       if(check_edumark_ip()) $_SESSION['ADMIN'] = true;
        return $_SESSION['ADMIN'];
    }


if(!$_SESSION['ADMIN'] ) {
    if ($act != 'admin.login' && $act != 'admin.logout') {
        $_SESSION['redir'] = getenv('REQUEST_URI');
        WebApp::redirect('admin.login');
    }
	

	}else{
	
	/*		'u' => '중간관리자3', 
			'q' => '중간관리자2', 
			'k' => '중간관리자1', 
			'a' => '최고관리자' );
	*/
	
	//제한될 페이지 목록
	$actr_page =array();	

	switch ($_SESSION['CHR_MTYPE']) {
		case "a":

		break;
		
		case "u": //중간관리자3 //스탁 강사(삭제)
			
	
		$actr_page[page][] = "skin";
		$actr_page[page][] = "attach";
		$actr_page[page][] = "menu";
		$actr_page[page][] = "member";
		//$actr_page[page][] = "sms";
		//$actr_page[page][] = "poll";
		//$actr_page[page][] = "popup";
		
		//lexbiner
		//jb7024
		// 칸트파워는 볼수있도록 2009-02-17 종태
		if($_SESSION[USERID] == "lexbiner" && $_OID == 20252){
		
		}else{
		$actr_page[page][] = "lms";
		}
		

		 break;
		
		case "q": //중간관리자2 //스탁 직원


	
		$actr_page[page][] = "skin";
		$actr_page[page][] = "attach";
		$actr_page[page][] = "menu";
		//$actr_page[page][] = "member";
		//$actr_page[page][] = "sms";
		//$actr_page[page][] = "poll";
		//$actr_page[page][] = "popup";
		//$actr_page[page][] = "lms";

		 break;
		
		case "k"://중간관리자1 // 중간관리자
		
		$actr_page[page][] = "skin";
		$actr_page[page][] = "attach";
		//$actr_page[page][] = "menu";
		//$actr_page[page][] = "member";
		//$actr_page[page][] = "sms";
		//$actr_page[page][] = "poll";
		//$actr_page[page][] = "popup";
		//$actr_page[page][] = "lms";
		 break;
		}
	
	
	
	
	}
}
for($ii=0; $ii<count($actr_page[page]); $ii++) {
	 
	 $tact =  explode(".",$act);
		
	 if($tact[0]==$actr_page[page][$ii]) {
		WebApp::moveBack('접근할 권한이 없습니다.');
		exit;
	 }
	
}


$DB = &WebApp::singleton('DB');
//2009-07-24 바로가기 메뉴
if($_SESSION[ADMIN]) {
	$sql = "select * from TAB_MENU_INDEX where num_oid = $_OID ";
	$menu_index = $DB -> sqlFetchAll($sql);
	$tpl->assign(array('MENU_INDEX'=>$menu_index));
}



 ?>