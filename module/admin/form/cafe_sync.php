<?
/*
	작성 : Wes 
	용도 : DB 이상으로 누락된 학급편성의 의한 Cafe Table Sync 맞추기
	일자 : 2008년 03월 04일
*/
$Tab_Formation 		= "TAB_FORMATION_SET";
$Tab_Formation_History 	= "TAB_FORMATION_HISTORY";
$Tab_Grade 		= "TAB_CLASS_GRADE";
$Tab_Cafe		= "TAB_CAFE";
$DB = &WebApp::singleton('DB');

if($REMOTE_ADDR=="203.109.24.220"){
		
		##	교실의 창(학급 홈피) 생성 전에 기존 카페가 있으면  삭제할것. 
		$sql = "select str_cafe_id, str_grade, str_class FROM $Tab_Formation Where num_oid = ".$oid. " AND num_year='$school_year' AND str_cafe_id like '$school_year%'";					
		$forCafe = $DB->sqlFetchAll($sql);		
		@array_walk($forCafe,'cb_format_list');


		##	기존 교실의 창을 생성, 삭제. 
		include_once("module/cafe/util/cafe_manage.php");						
		if(!$CafeDB){
			require_once "class.DB.php";
			$CafeDB = new DB('cafedb');
		}						
				
		##	학급 생성					
		foreach( $forCafe as $row ){
										
		    $sql = "select count(*) from tab_cafe where num_oid=$oid and str_cafe_id = '".$row['str_cafe_id']."'";
			$is_cafe = $CafeDB->sqlFetchOne($sql);				

			// 교실의 창(학급 홈피) 생성...						
			if(!$is_cafe){
				echo " Insert Cafe " . $oid. ":". $row['str_cafe_id'].":". $row['str_grade'].":".$row['str_class'].":class_homepage <br>";
				make_cafe_info($CafeDB, $oid, $row['str_cafe_id'], $row['str_grade']." ".$row['str_class'], "class_homepage");
			}
										
		}		
}else{
	echo "access Deny";
}
?>