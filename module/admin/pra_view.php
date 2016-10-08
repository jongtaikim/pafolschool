<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2009-07-25
* 작성자: 김종태
* 설   명: 정책미리보기
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
			$DOC_TITLE = "str:이메일 주소 무단 수집 거부";
			$tpl->define("CONTENT", Display::getTemplate("admin/par_email.htm"));		
		 break;

		}



?>