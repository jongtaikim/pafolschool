<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2009-07-20
* �ۼ���: ������
* ��   ��: ����������ȣ��å �Է�
*****************************************************************
* 
*/

switch ($REQUEST_METHOD) {
	case "GET":
	
	$_COPY = WebApp::getConf('copy');
	$content = file_get_contents(_DOC_ROOT.'/hosts/'.HOST.'/conf/member3.conf.php');
	
	$tpl->assign($_COPY);
	$tpl->assign(array(
	 'content'=>$content,
	));


	$tpl->setLayout('no3');
	$tpl->define("CONTENT", Display::getTemplate("admin/pra3.htm"));
	
	 break;
	case "POST":

			 $FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
			$FTP->put_string($content,_DOC_ROOT.'/hosts/'.HOST.'/conf/member3.conf.php');		
        
			WebApp::moveBack('����Ǿ����ϴ�.');
	
	 break;
	}

?>