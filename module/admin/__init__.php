<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2008-10-28
* �ۼ���: ������
* ��  ��:  ���Ѻ� ������������ �̿���� ����
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
	
	/*		'u' => '�߰�������3', 
			'q' => '�߰�������2', 
			'k' => '�߰�������1', 
			'a' => '�ְ������' );
	*/
	
	//���ѵ� ������ ���
	$actr_page =array();	

	switch ($_SESSION['CHR_MTYPE']) {
		case "a":

		break;
		
		case "u": //�߰�������3 //��Ź ����(����)
			
	
		$actr_page[page][] = "skin";
		$actr_page[page][] = "attach";
		$actr_page[page][] = "menu";
		$actr_page[page][] = "member";
		//$actr_page[page][] = "sms";
		//$actr_page[page][] = "poll";
		//$actr_page[page][] = "popup";
		
		//lexbiner
		//jb7024
		// ĭƮ�Ŀ��� �����ֵ��� 2009-02-17 ����
		if($_SESSION[USERID] == "lexbiner" && $_OID == 20252){
		
		}else{
		$actr_page[page][] = "lms";
		}
		

		 break;
		
		case "q": //�߰�������2 //��Ź ����


	
		$actr_page[page][] = "skin";
		$actr_page[page][] = "attach";
		$actr_page[page][] = "menu";
		//$actr_page[page][] = "member";
		//$actr_page[page][] = "sms";
		//$actr_page[page][] = "poll";
		//$actr_page[page][] = "popup";
		//$actr_page[page][] = "lms";

		 break;
		
		case "k"://�߰�������1 // �߰�������
		
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
		WebApp::moveBack('������ ������ �����ϴ�.');
		exit;
	 }
	
}


$DB = &WebApp::singleton('DB');
//2009-07-24 �ٷΰ��� �޴�
if($_SESSION[ADMIN]) {
	$sql = "select * from TAB_MENU_INDEX where num_oid = $_OID ";
	$menu_index = $DB -> sqlFetchAll($sql);
	$tpl->assign(array('MENU_INDEX'=>$menu_index));
}



 ?>