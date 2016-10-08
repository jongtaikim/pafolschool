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
		
		$DOC_TITLE = "str:개인정보보호정책";

		if($_MEMBER[standard] =="Y" || $standard == "Y"){
			$tpl->define("CONTENT", Display::getTemplate("admin/pra_view.htm"));		
		}else{
			
			$content ='/hosts/'.HOST.'/conf/member1.conf.php';

			$tpl->define("CONTENT", $content);		
		}
		 break;
		case "pra2":
		$_COPY = WebApp::getConf('copy');
		$tpl->assign($_COPY);
		
		$DOC_TITLE = "str:저작권 보호 지침";

		if($_COPY[standard2] =="Y" || $standard == "Y"){
			$tpl->define("CONTENT", Display::getTemplate("admin/pra_view2.htm"));		
		}else{
			$content ='/hosts/'.HOST.'/conf/member2.conf.php';
			$tpl->define("CONTENT", $content);		
		}

	
				
		 break;

		 case "pra3":
		$_COPY = WebApp::getConf('copy');
		$tpl->assign($_COPY);
		
		$DOC_TITLE = "str:홈페이지 이용약관";

		if($_COPY[standard2] =="Y" || $standard == "Y"){
			$tpl->define("CONTENT", Display::getTemplate("admin/pra_view3.htm"));		
		}else{
			$content ='/hosts/'.HOST.'/conf/member3.conf.php';
			$tpl->define("CONTENT", $content);		
		}

	
				
		 break;

		 case "user":
			$DOC_TITLE = "str:홈페이지 이용약관";
			$tpl->define("CONTENT", Display::getTemplate("admin/pra_user.htm"));		
		 break;

 		 case "email":
			$DOC_TITLE = "str:이메일 주소 무단 수집 거부";
			$tpl->define("CONTENT", Display::getTemplate("admin/par_email.htm"));		
		 break;

		}



?>