<?
/************************************
설명 :홈페이지 회원권한 명 지정
개발 : 김종태
디자인 :이선화
날짜 :2008-01-21 
************************************/

$DB = &WebApp::singleton("DB");
switch ($REQUEST_METHOD) {
	case "GET":
	

	$_member_type = WebApp::getConf('member_type');
	$tpl->assign($_member_type);
	
	
	$tpl->define("CONTENT", Display::getTemplate("member/admin/mtype.htm"));
	
	 break;
	case "POST":
	 
$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
           
     
			$INI = &WebApp::singleton("IniFile");
			$INI->load('hosts/'.HOST.'/conf/global.conf.php');
			$INI->delSection("member_type");
			foreach( $_REQUEST as $val => $value )
			{
			if($val == "end")  break;
			if($value !="") {
			if($val =="xx") {
			$INI->setVar('x',$value,"member_type");		
			}else{
			$INI->setVar($val,$value,"member_type");		
			}
			}
			
			} 


			$FTP->put_string($INI->_combine(),_DOC_ROOT.'/hosts/'.HOST.'/conf/global.conf.php');		

	WebApp::moveBack('설정되었습니다.');


WebApp::moveBack('적용되었습니다.');


	break;
	}

?>