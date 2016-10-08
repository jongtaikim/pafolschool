<?php
/*
	작성 : Wes 
	용도 : 학급편성 간편하게 만들기
	일자 : 2007년 02월 08일
*/
$Tab_Formation 		= "TAB_FORMATION_SET";
$Tab_Formation_History 	= "TAB_FORMATION_HISTORY";
$Tab_Grade 		= "TAB_CLASS_GRADE";
$school_year = WebApp::getConf('formation.school_year');
$DB = &WebApp::singleton('DB');
		
switch ($REQUEST_METHOD) {
	case "GET":
		
		// 기존 학년 정보가 없을때 학년정보 만들기 POPUP 후, 창 Close 
		$sql = "select count(num_oid) from ".$Tab_Grade." where num_oid = ".$oid;				
		$count_grade = $DB->sqlFetchOne($sql);
		if($count_grade==0){
			WebApp::alert('학년정보가 없습니다. 우선 학년만들기로 학년을 만들어주세요.');
			WebApp::closeWin();
		}
				
		// History 를 위한 해당 년도
		$num_year = "<option>".$school_year."</option>";		
		
		// 간편 만들기 이전에 기존 학급정보가 존재하는지 확인
		$sql = "select count(num_oid) from ".$Tab_Formation." where num_oid = ".$oid." AND num_year='".$school_year."'";		
		$is_empty = $DB->sqlFetchOne($sql);							
		if($is_empty>=1)$print_empty="간편만들기 사용시 현재 있는 $is_empty 개의 학급정보는 삭제됩니다. ";		
		
		// 한학년내의 반갯수
		$print_class="<option value=''>선택</option>";
		for($i=1;$i<30;$i++){
			$print_class .= "<option value='$i'>$i 개</option>";
		}

		$sql = "select rownum, num_grade, str_grade, num_next_grade, num_start_grade from ".$Tab_Grade.		
		" connect by prior num_oid = num_oid And ".		
		" prior num_next_grade=num_grade ".
		" start with num_oid = ".$oid. " And num_start_grade = 1 ";	
		$dataNum = $DB->sqlFetchAll($sql);							
		
		$tpl->setLayout('admin');
		$tpl->define("CONTENT", Display::getTemplate("admin/form/main_wizard.htm"));



		$tpl->assign(array(
									'num_year'=>$num_year,
									'GRADE'=>$dataNum,
									'print_empty'=>$print_empty,
									'print_class'=>$print_class,
									));
		
		

		break;



	case "POST":
		$cache_file = _DOC_ROOT.'/hosts/'.HOST.'/'."inc.main.classObj.htm";
		 unlink($cache_file);
				
		##	기존 학급 편성을 Backup 후 현재 학급을 삭제한다. ( data 와 ip 추가 )						
		if(!$num_year)WebApp::moveBack('해당년도가 없습니다.');
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
			From $Tab_Formation where num_oid = ".$oid." AND num_year='".$num_year."'";		
		$DB->sqlQuery($InsertSql); 
		$DB->commit();
		

		##	기존 교실의 창을 생성, 삭제. 


		##	새로 만들기
		$classSize = count($num_grade);
		if($classSize==0)WebApp::moveBack('선택된 반갯수가 없습니다.');
		$num_order = 1;
					

		##	교실의 창(학급 홈피) 생성 전에 기존 카페 삭제할것. 
		$sql = "select str_cafe_id FROM $Tab_Formation Where num_oid = ".$oid. " AND num_year='$school_year'";					
		$forCafe = $DB->sqlFetchAll($sql);		
		


		$FH = &WebApp::singleton('FileHost');
		$_OID = _OID;
		for($ii=0; $ii<count($forCafe); $ii++) {
		
		$pcode = $forCafe[$ii][str_cafe_id];
		// MENU Module DB 삭제
		$sql = "DELETE FROM ".TAB_PARTY_BOARD." WHERE num_oid=$_OID AND num_pcode=$pcode";
		$DB->query($sql);
		$DB->commit();
		$sql = "DELETE FROM ".TAB_PARTY_BOARD_CONFIG." WHERE num_oid=$_OID AND num_pcode=$pcode";
		$DB->query($sql);
		$DB->commit();
		$sql = "DELETE FROM ".TAB_PARTY_BOARD_COMMENT." WHERE num_oid=$_OID AND num_pcode=$pcode";
		$DB->query($sql);
		$DB->commit();
		
		$sql = "DELETE FROM ".TAB_PARTY_MENU." WHERE num_oid=$_OID AND num_pcode=$pcode";
		$DB->query($sql);
		$DB->commit();
		//2009-04-14 현민 멤버도 삭제
		$sql = "DELETE FROM ".TAB_PARTY_MEMBER." WHERE num_oid=$_OID AND num_pcode=$pcode";
		$DB->query($sql);
		$DB->commit();
		
		$sql = "DELETE FROM ".TAB_PARTY." WHERE num_oid=$_OID AND num_pcode=$pcode";
		$DB->query($sql);
		$DB->commit();
		
		

		$FH->delete_as_code('party',$pcode);
		}
		
		$sql="DELETE FROM ".$Tab_Formation." WHERE num_oid=".$oid." AND num_year = '".$num_year."'";
		$DB->sqlQuery($sql); 
		$DB->commit();

		
		
		include _DOC_ROOT.'/module/party/cafe_add_lib.php';
		


		##	학급 생성					
		for( $i=0; $i < $classSize; $i++ ){
				
			$school_grade = "school_grade".$num_grade[$i];						
			if($$school_grade){
				
				for( $j=1; $j < ($$school_grade+1); $j++ ){
					
					$str_cafe_id = $num_year. sprintf("%02d",$num_grade[$i]) . sprintf("%02d",$j);
					$str_class = $j."반" ;
					
					$sql = "INSERT INTO ".$Tab_Formation."( NUM_OID,NUM_YEAR,NUM_GRADE,NUM_CLASS,STR_CAFE_ID,STR_GRADE,STR_CLASS,NUM_ORDER ) ".
					" VALUES(".$oid.",'".$num_year."','".$num_grade[$i]."','".$j."','".$str_cafe_id."','".$str_grade[$i]."','".$str_class."','".$num_order."')";
							
					$DB->sqlQuery($sql); 
					$DB->commit();
					
					
					// 교실의 창(학급 홈피) 생성...
					// 실제 카페 생성하는 구문 넣어야 함. **********************************************								
					

					$title = $str_class."";
					$cafe_memo = $str_class." 학급홈페이지입니다.";
					$cate_type = "class";
					addCafe($str_cafe_id,$cate_type,$str_id,$title,$cafe_memo);
		
								
					$num_order++;
				}
			}
			
		}		
				
		echo "<script language='javascript'>alert('학급편성이 완료되었습니다.');window.opener.document.location.reload();window.self.close();</script>";
}

function cb_format_list(&$arr) {			
	global  $oid;

}
?>