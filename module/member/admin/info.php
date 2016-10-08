<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-01-30
* 작성자: 김종태
* 설  명: 회원가입폼 설정
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');
switch ($REQUEST_METHOD) {
	case "GET":

	$content1 = file_get_contents(_DOC_ROOT.'/hosts/'.HOST.'/conf/member1.conf.php');
	$content2 = file_get_contents(_DOC_ROOT.'/hosts/'.HOST.'/conf/member2.conf.php');
	$content3 = file_get_contents(_DOC_ROOT.'/hosts/'.HOST.'/conf/member3.conf.php');
	$content4 = file_get_contents(_DOC_ROOT.'/hosts/'.HOST.'/conf/member4.conf.php');
	

	$tpl->assign($_MEMBER);
	$tpl->assign(array('content1'=>$content1,'content2'=>$content2,'content3'=>$content3,'content4'=>$content4));




	$tpl->define("CONTENT", Display::getTemplate("member/admin/info.htm"));
	
	 break;
	case "POST":

			$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
            					

			$FTP->put_string($content1,_DOC_ROOT.'/hosts/'.HOST.'/conf/member1.conf.php');		
			$FTP->put_string($content2,_DOC_ROOT.'/hosts/'.HOST.'/conf/member2.conf.php');		
			$FTP->put_string($content3,_DOC_ROOT.'/hosts/'.HOST.'/conf/member3.conf.php');		
			$FTP->put_string($content4,_DOC_ROOT.'/hosts/'.HOST.'/conf/member4.conf.php');		

	WebApp::moveBack('설정되었습니다.');
	 
	 break;
	}

?>