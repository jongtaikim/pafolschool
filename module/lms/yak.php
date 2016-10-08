<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-01-30
* 작성자: 김종태
* 설  명: 몰라임마~!
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');


switch ($REQUEST_METHOD) {
	case "GET":
	
	if(!$_SESSION[USERID]){
		//reurl
		echo '<script>alert("로그인이 필요합니다.");</script>';
		echo "<meta http-equiv='Refresh' Content=\"0; URL='/member.login?reurl=".urlencode($_SERVER["REQUEST_URI"])."'\">";
		exit;
		
	}
	


	if($_SESSION[CHR_MTYPE]!="g"){
		if($_SESSION[CHR_MTYPE]!="z"){
		WebApp::moveBack('학부모 회원만 이용가능합니다.');
		exit;
		}
	}
	
	if($hold != "y"){
		$DOC_TITLE = "str:참가신청 약관 동의";
	}else{
		$DOC_TITLE = "str:신청 약관 동의(대기자)";
	}

	$tpl->setLayout('@sub');
	$tpl->define("CONTENT", Display::getTemplate("lms/yak.htm"));
	
	 break;
	case "POST":
	 break;
	}

?>