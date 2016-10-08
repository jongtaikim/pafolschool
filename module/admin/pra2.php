<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2009-07-20
* 작성자: 김종태
* 설   명: 개인정보보호정책 입력
*****************************************************************
* 
*/

switch ($REQUEST_METHOD) {
	case "GET":
	
	$_COPY = WebApp::getConf('copy');
	$content = file_get_contents(_DOC_ROOT.'/hosts/'.HOST.'/conf/member2.conf.php');
	
	$tpl->assign($_COPY);
	$tpl->assign(array(
	 'content'=>$content,
	));


	$tpl->setLayout('no3');
	$tpl->define("CONTENT", Display::getTemplate("admin/pra2.htm"));
	
	 break;
	case "POST":

			 $FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
			$FTP->put_string($content,_DOC_ROOT.'/hosts/'.HOST.'/conf/member2.conf.php');		
        
			$INI = &WebApp::singleton("IniFile");
			$INI->load('hosts/'.HOST.'/conf/global.conf.php');
			
			$INI->setVar("copy_no",$copy_no);

			$INI->setVar("copy_dept",$copy_dept,"copy");
			$INI->setVar("copy_name",$copy_name,"copy");
			$INI->setVar("copy_email",$copy_email,"copy");

			$INI->setVar("standard2",$standard2,"copy");
			$FTP->put_string($INI->_combine(),_DOC_ROOT.'/hosts/'.HOST.'/conf/global.conf.php');
	
			WebApp::moveBack('적용되었습니다.');
	
	 break;
	}

?>