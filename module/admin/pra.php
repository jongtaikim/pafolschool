<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2009-07-20
* 작성자: 김종태
* 설   명: 개인정보보호정책 입력
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');


switch ($REQUEST_METHOD) {
	case "GET":
	


	$_MEMBER = WebApp::getConf('member');
	$content = file_get_contents(_DOC_ROOT.'/hosts/'.HOST.'/conf/member1.conf.php');
	
	
	
	$tpl->assign($_MEMBER);
	$tpl->assign(array(
	 'content'=>$content,
	));

	$tpl->setLayout('no3');
	$tpl->define("CONTENT", Display::getTemplate("admin/pra.htm"));
	
	 break;
	case "POST":

		
	
			$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
			$FTP->put_string($content,_DOC_ROOT.'/hosts/'.HOST.'/conf/member1.conf.php');		
        
			$INI = &WebApp::singleton("IniFile");
			$INI->load('hosts/'.HOST.'/conf/global.conf.php');
			$INI->setVar("dept_file_name",$dept_file_name,"member");
			$INI->setVar("dept_name",$dept_name,"member");
			$INI->setVar("dept_tel",$dept_tel,"member");
			$INI->setVar("drct_email",$drct_email,"member");
			$INI->setVar("drct_tel",$drct_tel,"member");
			$INI->setVar("drct_fax",$drct_fax,"member");
			$INI->setVar("dept_area",$dept_area,"member");
			$INI->setVar("drct_dept",$drct_dept,"member");
			$INI->setVar("drct_name",$drct_name,"member");
			$INI->setVar("drct_email",$drct_email,"member");
			$INI->setVar("drct_tel",$drct_tel,"member");
			$INI->setVar("drct_fax",$drct_fax,"member");

			$INI->setVar("standard",$standard,"member");
			$FTP->put_string($INI->_combine(),_DOC_ROOT.'/hosts/'.HOST.'/conf/global.conf.php');
		
			WebApp::moveBack('적용되었습니다.');
	
	 break;
	}

?>