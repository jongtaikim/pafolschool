<?
/*
	�ۼ� : Wes 
	�뵵 : DB �̻����� ������ �б����� ���� Cafe Table Sync ���߱�
	���� : 2008�� 03�� 04��
*/
$Tab_Formation 		= "TAB_FORMATION_SET";
$Tab_Formation_History 	= "TAB_FORMATION_HISTORY";
$Tab_Grade 		= "TAB_CLASS_GRADE";
$Tab_Cafe		= "TAB_CAFE";
$DB = &WebApp::singleton('DB');

if($REMOTE_ADDR=="203.109.24.220"){
		
		##	������ â(�б� Ȩ��) ���� ���� ���� ī�䰡 ������  �����Ұ�. 
		$sql = "select str_cafe_id, str_grade, str_class FROM $Tab_Formation Where num_oid = ".$oid. " AND num_year='$school_year' AND str_cafe_id like '$school_year%'";					
		$forCafe = $DB->sqlFetchAll($sql);		
		@array_walk($forCafe,'cb_format_list');


		##	���� ������ â�� ����, ����. 
		include_once("module/cafe/util/cafe_manage.php");						
		if(!$CafeDB){
			require_once "class.DB.php";
			$CafeDB = new DB('cafedb');
		}						
				
		##	�б� ����					
		foreach( $forCafe as $row ){
										
		    $sql = "select count(*) from tab_cafe where num_oid=$oid and str_cafe_id = '".$row['str_cafe_id']."'";
			$is_cafe = $CafeDB->sqlFetchOne($sql);				

			// ������ â(�б� Ȩ��) ����...						
			if(!$is_cafe){
				echo " Insert Cafe " . $oid. ":". $row['str_cafe_id'].":". $row['str_grade'].":".$row['str_class'].":class_homepage <br>";
				make_cafe_info($CafeDB, $oid, $row['str_cafe_id'], $row['str_grade']." ".$row['str_class'], "class_homepage");
			}
										
		}		
}else{
	echo "access Deny";
}
?>