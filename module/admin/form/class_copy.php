<?php
/*
	작성 : Wes 
	용도 : 작년 학급편성을 올해 학급편성으로 Copy 하기
	일자 : 2008년 01월 31일
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
		
		// 학년 정보가 없을때 학년정보 만들기 POPUP 후, 창 Close 
		$sql = "select count(num_oid) from ".$Tab_Grade." where num_oid = ".$oid;				
		$count_grade = $DB->sqlFetchOne($sql);
		if($count_grade==0){
			WebApp::alert('학년정보가 없습니다. 우선 학년만들기로 학년을 만들어주세요.');
			WebApp::closeWin();
		}
		
		$sql="select count(*) FROM ".$Tab_Formation." WHERE num_oid=".$oid." AND num_year = '".$school_year."'";
		$count_class = $DB->sqlFetchOne($sql);
		if($count_class>0){
			WebApp::alert('이미 $school_year 년의 학급 정보가 있습니다.  ');
			WebApp::closeWin();
		}

		$sql="select count(*) FROM ".$Tab_Formation." WHERE num_oid=".$oid." AND num_year = '".$last_year."'";
		$count_last = $DB->sqlFetchOne($sql);
		if($count_last==0){
			WebApp::alert('지난 $num_year 년의 학급 정보가 없습니다. 학급편성으로 학급을 생성하세요 ');
			WebApp::closeWin();
		}			

		##	기존 학급 편성을 copy 한후 Backup 
		if(!$school_year)WebApp::moveBack('해당년도가 없습니다.');
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
		
		##	기존 교실의 창을 생성, 삭제. 
		include_once("module/cafe/util/cafe_manage.php");						
		if(!$CafeDB){
			require_once "class.DB.php";
			$CafeDB = new DB('cafedb');
		}						
									

		##	교실의 창(학급 홈피) 생성 전에 기존 카페가 있으면  삭제할것. 
		$sql = "select str_cafe_id, str_grade, str_class FROM $Tab_Formation Where num_oid = ".$oid. " AND num_year='$school_year'";					
		$forCafe = $DB->sqlFetchAll($sql);		
		@array_walk($forCafe,'cb_format_list');
		
		##	학급 생성					
		foreach( $forCafe as $row ){
											
			// 교실의 창(학급 홈피) 생성...						
			make_cafe_info($CafeDB, $oid, $row['str_cafe_id'], $row['str_grade']." ".$row['str_class'], "class_homepage");
										
		}		
		
		echo "<script language='javascript'>alert('$school_year 학급편성이 완료되었습니다.');document.location.href='/?act=admin.form.main';</script>";
				
		break;
	case "POST":
		break;				
}

function cb_format_list(&$arr) {
	// tab_cafe table 의 정보가 있을경우 해당 정보만 삭제			
	global $CafeDB, $oid;
	if($arr['str_cafe_id'])del_cafe_info($CafeDB, $oid, $arr['str_cafe_id']);
}
?>                                                                                                                                                                                                                                                                                                                                         