<?php
/*
	�ۼ� : Wes 
	�뵵 : �г��� ����� (��,��,��) ����
	���� : 2007�� 02�� 21��
*/
$Tab_Grade = "TAB_CLASS_GRADE";
$Tab_Organ = "TAB_ORGAN";
$DB = &WebApp::singleton('DB');
		
switch ($REQUEST_METHOD) {
	case "GET":								
	


		// ������ �г⿡ ������� �г������ ����				
		$sql = "select count(*) from ".$Tab_Grade." where num_oid = ".$oid;		
		$countGrade = $DB->sqlFetchOne($sql);																	
		if($countGrade>0)WebApp::redirect('/admin.form.main_grade'); 				
					
		// ������ �г��� ���� ��� ��,��,�� ���� Default �� �г��� �����Ұ�.
		$sql = "select str_school from ".$Tab_Organ." where num_oid = ".$oid;
		$selection = strtoupper($DB->sqlFetchOne($sql));					
		
		
		$tpl->setLayout('admin'); 
		$tpl->define('CONTENT','html/admin/form/main_grade_intro.htm');				
		$tpl->assign(array('selection'=>$selection));
		
		
				
		break;

	case "POST":										
		WebApp::moveBack('���������� �����Դϴ�.'); 		
		break;
}
?>