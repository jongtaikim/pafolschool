<?php
/*
	작성 : Wes 
	용도 : 학년편성 만들기 (초,중,고) 선택
	일자 : 2007년 02월 21일
*/
$Tab_Grade = "TAB_CLASS_GRADE";
$Tab_Organ = "TAB_ORGAN";
$DB = &WebApp::singleton('DB');
		
switch ($REQUEST_METHOD) {
	case "GET":								
	


		// 기존에 학년에 있을경우 학년관리로 보냄				
		$sql = "select count(*) from ".$Tab_Grade." where num_oid = ".$oid;		
		$countGrade = $DB->sqlFetchOne($sql);																	
		if($countGrade>0)WebApp::redirect('/admin.form.main_grade'); 				
					
		// 기존에 학년이 없을 경우 초,중,고에 따라서 Default 로 학년을 선택할것.
		$sql = "select str_school from ".$Tab_Organ." where num_oid = ".$oid;
		$selection = strtoupper($DB->sqlFetchOne($sql));					
		
		
		$tpl->setLayout('admin'); 
		$tpl->define('CONTENT','html/admin/form/main_grade_intro.htm');				
		$tpl->assign(array('selection'=>$selection));
		
		
				
		break;

	case "POST":										
		WebApp::moveBack('허용되지않은 접근입니다.'); 		
		break;
}
?>