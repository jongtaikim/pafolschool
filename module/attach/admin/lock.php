<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2008-10-16
* �ۼ���: ������
* ��  ��: ���̾ƿ� ���
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