<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2008-01-30
* �ۼ���: ������
* ��  ��: �����Ӹ�~!
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');


switch ($REQUEST_METHOD) {
	case "GET":
	
	if(!$_SESSION[USERID]){
		//reurl
		echo '<script>alert("�α����� �ʿ��մϴ�.");</script>';
		echo "<meta http-equiv='Refresh' Content=\"0; URL='/member.login?reurl=".urlencode($_SERVER["REQUEST_URI"])."'\">";
		exit;
		
	}
	


	if($_SESSION[CHR_MTYPE]!="g"){
		if($_SESSION[CHR_MTYPE]!="z"){
		WebApp::moveBack('�кθ� ȸ���� �̿밡���մϴ�.');
		exit;
		}
	}
	
	if($hold != "y"){
		$DOC_TITLE = "str:������û ��� ����";
	}else{
		$DOC_TITLE = "str:��û ��� ����(�����)";
	}

	$tpl->setLayout('@sub');
	$tpl->define("CONTENT", Display::getTemplate("lms/yak.htm"));
	
	 break;
	case "POST":
	 break;
	}

?>