<?php
/*
	�ۼ� : Wes 
	�뵵 : �۳� �б����� ���� �б������� Copy �ϱ�
	���� : 2008�� 01�� 31��
*/
$Tab_Formation 		= "TAB_FORMATION_SET";
$Tab_Formation_History 	= "TAB_FORMATION_HISTORY";
$Tab_Grade 		= "TAB_CLASS_GRADE";
$Tab_Cafe		= "TAB_CAFE";
$school_year = WebApp::getConf('formation.school_year');
$DB = &WebApp::singleton('DB');

$last_year = $school_year-1;
		
switch ($REQUEST_METHOD) {
	case "GET":
		
		// �г� ������ ������ �г����� ����� POPUP ��, â Close 
		$sql = "select count(num_oid) from ".$Tab_Grade." where num_oid = ".$oid;				
		$count_grade = $DB->sqlFetchOne($sql);
		if($count_grade==0){
			WebApp::alert('�г������� �����ϴ�. �켱 �г⸸���� �г��� ������ּ���.');
			WebApp::closeWin();
		}
		
		$sql="select count(*) FROM ".$Tab_Formation." WHERE num_oid=".$oid." AND num_year = '".$school_year."'";
		$count_class = $DB->sqlFetchOne($sql);
		if($count_class>0){
			WebApp::alert('�̹� $school_year ���� �б� ������ �ֽ��ϴ�.  ');
			WebApp::closeWin();
		}

		$sql="select count(*) FROM ".$Tab_Formation." WHERE num_oid=".$oid." AND num_year = '".$last_year."'";
		$count_last = $DB->sqlFetchOne($sql);
		if($count_last==0){
			WebApp::alert('���� $num_year ���� �б� ������ �����ϴ�. �б������� �б��� �����ϼ��� ');
			WebApp::closeWin();
		}			

		##	���� �б� ���� copy ���� Backup 
		if(!$school_year)WebApp::moveBack('�ش�⵵�� �����ϴ�.');
		$InsertSql = "	
			Insert Into $Tab_Formation(
			  NUM_OID,
			  NUM_YEAR,
			  NUM_GRADE,
			  NUM_CLASS,
			  NUM_ORDER,
			  STR_GRADE,
			  STR_CLASS,
			  STR_CAFE_ID,
			  STR_HOMEPAGE
			  ) 			
			Select 
			  NUM_OID,
			  '$school_year',
			  NUM_GRADE,
			  NUM_CLASS,
			  NUM_ORDER,
			  STR_GRADE,
			  STR_CLASS,
			'$school_year' || substr(STR_CAFE_ID, 5, 4) as cafe_id,
			  STR_HOMEPAGE			  
			From $Tab_Formation where num_oid = ".$oid." AND num_year='".$last_year."' AND str_cafe_id like '".$last_year."%'";

		$DB->sqlQuery($InsertSql); 
		$DB->commit();
		

		$InsertSql = "	
			Insert Into $Tab_Formation_History(
			  NUM_OID,
			  NUM_YEAR,
			  NUM_GRADE,
			  NUM_CLASS,
			  NUM_ORDER,
			  STR_GRADE,
			  STR_CLASS,
			  STR_CAFE_ID,
			  STR_HOMEPAGE,
			  DT_DATE,
			  STR_IP) 			
			Select 
			  NUM_OID,
			  NUM_YEAR,
			  NUM_GRADE,
			  NUM_CLASS,
			  NUM_ORDER,
			  STR_GRADE,
			  STR_CLASS,
			  STR_CAFE_ID,
			  STR_HOMEPAGE,
			  SYSDATE,
			  '$REMOTE_ADDR'
			From $Tab_Formation where num_oid = ".$oid." AND num_year='".$school_year."'";		
		$DB->sqlQuery($InsertSql); 
		$DB->commit();
		
		##	���� ������ â�� ����, ����. 
		include_once("module/cafe/util/cafe_manage.php");						
		if(!$CafeDB){
			require_once "class.DB.php";
			$CafeDB = new DB('cafedb');
		}						
									

		##	������ â(�б� Ȩ��) ���� ���� ���� ī�䰡 ������  �����Ұ�. 
		$sql = "select str_cafe_id, str_grade, str_class FROM $Tab_Formation Where num_oid = ".$oid. " AND num_year='$school_year'";					
		$forCafe = $DB->sqlFetchAll($sql);		
		@array_walk($forCafe,'cb_format_list');
		
		##	�б� ����					
		foreach( $forCafe as $row ){
											
			// ������ â(�б� Ȩ��) ����...						
			make_cafe_info($CafeDB, $oid, $row['str_cafe_id'], $row['str_grade']." ".$row['str_class'], "class_homepage");
										
		}		
		
		echo "<script language='javascript'>alert('$school_year �б����� �Ϸ�Ǿ����ϴ�.');document.location.href='/?act=admin.form.main';</script>";
				
		break;
	case "POST":
		break;				
}

function cb_format_list(&$arr) {
	// tab_cafe table �� ������ ������� �ش� ������ ����			
	global $CafeDB, $oid;
	if($arr['str_cafe_id'])del_cafe_info($CafeDB, $oid, $arr['str_cafe_id']);
}
?>                                                                                                                                                                                                                                                                                                                                         