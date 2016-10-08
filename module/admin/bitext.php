<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2009-07-21
* 작성자: 김종태
* 설   명: 비속어 설정
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');

switch ($REQUEST_METHOD) {
	case "GET":
	
	$content = file_get_contents(_DOC_ROOT.'/hosts/'.HOST.'/conf/bi.conf.php');
	$tpl->assign(array('content'=>$content ));
	
	
	$tpl->setLayout('no3');
	$tpl->define("CONTENT", Display::getTemplate("admin/bitext.htm"));
	
	 break;
	case "POST":

			$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
			$FTP->put_string($content,_DOC_ROOT.'/hosts/'.HOST.'/conf/bi.conf.php');		
        
			$INI = &WebApp::singleton("IniFile");
			$INI->load('hosts/'.HOST.'/conf/global.conf.php');
			$INI->setVar("bi_no",$bi_no);
			$INI->setVar("jumin_no",$jumin_no);
			$FTP->put_string($INI->_combine(),_DOC_ROOT.'/hosts/'.HOST.'/conf/global.conf.php');
		
			WebApp::moveBack('적용되었습니다.');

	 break;
	}

?>