<?
//2008-01-04 종태
/**********************************
새로운 학교 관리자

프로그램 : 종태 
디자인 : 선화
**********************************/


	
	$tpl->setLayout('menu1'); // 레이아웃은 서브
	$tpl->define("CONTENT", WebApp::getTemplate("admin2/sub.htm"));
        $tpl->assign(array(
			'aa'=>$aa,
			));

?>