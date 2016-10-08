<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-10-16
* 작성자: 김종태
* 설  명: 레이아웃 잠금
*****************************************************************
* 
*/




 $FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
			$INI = &WebApp::singleton("IniFile");
			$INI->load('hosts/'.HOST.'/conf/global.conf.php');
			$INI->setVar($layout,$mo ,"layout_lock");
			$FTP->put_string($INI->_combine(),_DOC_ROOT.'/hosts/'.HOST.'/conf/global.conf.php');
WebApp::moveBack();

?>