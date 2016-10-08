<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2009-08-24
* 작성자: 김종태
* 설   명: 부가기능 노출설정
*****************************************************************
* 
*/


switch ($REQUEST_METHOD) {
	case "GET":
	
	$tpl->setLayout('no3');
	$tpl->define("CONTENT", Display::getTemplate("admin/bu_setup.htm"));


	$tpl->assign(array(
				'onlineOffice'=>_onlineOffice,
				'onlinePoll'=>_onlinePoll,
				'onlineForm'=>_onlineForm,
				'onlineVote'=>_onlineVote,
				'onlineAfter'=>_onlineAfter,
	 
				));
	
	


	 break;
	case "POST":
		
			$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
			$INI = &WebApp::singleton("IniFile");
			$INI->load('hosts/'.HOST.'/conf/global.conf.php');

			$INI->setVar("onlineOffice",$onlineOffice);
			$INI->setVar("onlinePoll",$onlinePoll);
			$INI->setVar("onlineForm",$onlineForm);
			$INI->setVar("onlineVote",$onlineVote);
			$INI->setVar("onlineAfter",$onlineAfter);
	
			$FTP->put_string($INI->_combine(),_DOC_ROOT.'/hosts/'.HOST.'/conf/global.conf.php');

			WebApp::moveBack('적용되었습니다.');
			
	 break;
	}

?>