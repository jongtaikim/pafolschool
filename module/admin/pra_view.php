<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2009-07-25
* �ۼ���: ������
* ��   ��: ��å�̸�����
*****************************************************************
* 
*/

if(!$layout) $tpl->setLayout('admin_xhtml'); else $tpl->setLayout('@sub');
global $organdb;

$tpl->assign($organdb);	

	switch ($mode) {
		case "pra":
		$_MEMBER = WebApp::getConf('member');
		$tpl->assign($_MEMBER);
		
			
			$content ='/hosts/'.HOST.'/conf/member1.conf.php';

			$tpl->define("CONTENT", $content);		
		
		 break;
		case "pra2":
		$_COPY = WebApp::getConf('copy');
		$tpl->assign($_COPY);
		
		
			$content ='/hosts/'.HOST.'/conf/member2.conf.php';
			$tpl->define("CONTENT", $content);		
		

	
				
		 break;

		 case "user":
				$content ='/hosts/'.HOST.'/conf/member3.conf.php';

			$tpl->define("CONTENT", $content);		
		 break;

 		 case "email":
			$DOC_TITLE = "str:�̸��� �ּ� ���� ���� �ź�";
			$tpl->define("CONTENT", Display::getTemplate("admin/par_email.htm"));		
		 break;

		}



?>