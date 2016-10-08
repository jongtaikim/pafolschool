<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2009-07-14
* 작성자: 김종태
* 설   명: 이웃닷컴 학년만들기 모듈 템플릿 언더바 컨버팅
*****************************************************************
* 
*/

$Tab_Grade = "TAB_CLASS_GRADE";
$Tab_Formation = "TAB_FORMATION_SET";
$TAB_CLASS_MEMBER = "TAB_CLASS_MEMBER";
$Tab_Organ = "TAB_ORGAN";
$DB = &WebApp::singleton('DB');
$school_year = WebApp::getConf('formation.school_year');
		
switch ($REQUEST_METHOD) {
	case "GET":								
		
		$sql = "select count(*) from ".$Tab_Grade." where num_oid = ".$oid;		
		$countGradeS = $DB->sqlFetchOne($sql);		
		
		if($countGradeS == 0 && $selection=="")WebApp::redirect('/admin.form.main_grade_intro');

		// 기존에 학년이 없을 경우 전Page 에서 선택된 초,중,고에 따라서 Default 로 학년을 넣어줄것.
		switch ($selection) {
			case "E" :
				$limit_grade=6;				
				break;
			case "M" :
				$limit_grade=3;			
				break;
			case "H" :
				$limit_grade=3;
				break;
			default	:							
		}

		
		for($i=1;$i<($limit_grade+1);$i++){			
			if($limit_grade != $i)
				$next_grade=$i+1;	
			else 
				$next_grade="";	
			
			// 입학학년 초기화 
			if($i==1)
				$num_start_grade=1;
			else
				$num_start_grade=0;
				
			$sql = "INSERT INTO ".$Tab_Grade."( NUM_OID,NUM_GRADE,STR_GRADE,NUM_NEXT_GRADE,NUM_START_GRADE) ".
			" VALUES(".$oid.",'".$i."','".$i."학년','".$next_grade."','".$num_start_grade."')";
			$DB->sqlQuery($sql); 
			$DB->commit();				
		}			
						
					
		// 진급 사용학교 학년정보 1-6학년은 초기 고정 (num_grade 1-6 까지 사용) 7-29까지는 진급용
		// 진급 사용안하는 학년정보 - 특수학년 혹은 통합 (num_grade 30 - 99 까지 )												
		$array_dot = split("\.", $REMOTE_ADDR);
		$ipbase = $array_dot[0].".".$array_dot[1].".".$array_dot[2];		
		
		
		
		
		
		
		// E-Wut.com 내부 IP인경우 관리자 HTML 보여줌
		if ($ipbase == '203.109.24' && $array_dot[3] >=192) {        								
		//if ($ipbase == '203.109.24' && (($array_dot[3] >=192 && $array_dot[3] <=197) ||  ($array_dot[3] >=199 && $array_dot[3] <=221)) ) {
		//if ($ipbase != '203.109.24') {   
			
			
			$tpl->define('CONTENT','html/admin/form/main_grade_ewut.htm');				

			$sql_main = "select num_grade as start_grade_num from ".$Tab_Grade. " where num_oid=".$oid." AND num_start_grade=1 ";
			
			$data = $DB->sqlFetchAll($sql_main);		
			for($ii=0; $ii<count($data); $ii++) {

				$sql = "select rownum, num_grade, str_grade, num_next_grade, num_start_grade from ".$Tab_Grade.		
				" connect by prior num_oid = num_oid And ".		
				" prior num_next_grade=num_grade ".
				" start with num_oid = ".$oid. " And num_grade=".$data[$ii]['start_grade_num']." And num_start_grade = 1 ";	
				$data[$ii][loop] = $DB -> sqlFetchAll($sql);
				@array_walk($data[$ii][loop],'cb_format_start_end');	
				
				$tpl->assign(array('start_grade_num'=>$data[$ii]['start_grade_num']));
			}

			//print_r($data);
			$tpl->assign(array('GRADE_LIST'=>$data));


		// E-Wut.com 내부 IP 가 아닌 경우에 보통 HTML 보여줌
		}else{

	

			$start_grade_num=1;
			$tpl->define('CONTENT','html/admin/form/main_grade.htm');				
			


			$sql_main = "select num_grade as start_grade_num from ".$Tab_Grade. " where num_oid=".$oid." AND num_start_grade=1 ";
			
			$data = $DB->sqlFetchAll($sql_main);		
			for($ii=0; $ii<count($data); $ii++) {

				$sql = "select rownum, num_grade, str_grade, num_next_grade, num_start_grade from ".$Tab_Grade.		
				" connect by prior num_oid = num_oid And ".		
				" prior num_next_grade=num_grade ".
				" start with num_oid = ".$oid. " And num_grade=".$data[$ii]['start_grade_num']." And num_start_grade = 1 ";	
				$data[$ii][loop] = $DB -> sqlFetchAll($sql);
				@array_walk($data[$ii][loop],'cb_format_start_end');	
		
				$tpl->assign(array('start_grade_num'=>$data[$ii]['start_grade_num']));
			}

			//print_r($data);
			$tpl->assign(array('GRADE_LIST'=>$data));

		}
		
		
		$tpl->setLayout('admin'); 
		

		



		break;

	case "POST":
				
		$cache_file = _DOC_ROOT.'/hosts/'.HOST.'/'."inc.main.classObj.htm";
		 unlink($cache_file);

		switch ($mode) {
				
			##	삭제시						
			case "del":
							
				$preGrade = $DB->sqlFetch("select num_grade, num_next_grade,num_start_grade from ".$Tab_Grade." where num_oid = ".$oid . " AND num_next_grade=".$num_grade);				
				$nextGrade = $DB->sqlFetch("select num_grade, num_next_grade from ".$Tab_Grade." where num_oid = ".$oid ." AND num_grade=".
						" (select num_next_grade from ".$Tab_Grade." Where num_oid=".$oid." AND num_grade=".$num_grade.")");
				
				if($preGrade['num_grade']){
					// 삭제전 이전진급과 연결되어 있고 다음 진급이 있을 경우  가운데 학년은 삭제되며 두 진급을 연결
					if($nextGrade['num_grade']){
						$sql = "UPDATE ".$Tab_Grade." set NUM_NEXT_GRADE = '".$nextGrade['num_grade']."' Where num_oid=".$oid." AND num_grade = ".$preGrade['num_grade'];
						$DB->sqlQuery($sql);
					// 삭제전 이전진급과 연결되어 있고 다음 진급이 없을경우 학년은 삭제되며 상위 진급을 졸업학년으로 변경						
					}else{
						$sql = "UPDATE ".$Tab_Grade." set NUM_NEXT_GRADE = '' Where num_oid=".$oid." AND num_grade = ".$preGrade['num_grade'];
						$DB->sqlQuery($sql);					
					}
				}else{
					$sql = "UPDATE ".$Tab_Grade." set NUM_START_GRADE = 1 Where num_oid=".$oid." AND num_grade = ".$nextGrade['num_grade'];
					$DB->sqlQuery($sql);									
				}
				
				// 학년을 삭제시 학년이하에 있는 학급 삭제및 카페 삭제
							
		

				$sql = "select count(num_class) count_class, max(num_order) max_order FROM $Tab_Formation Where num_oid = ".$oid. " AND num_grade=$num_grade AND num_year='$school_year'";
				$orderFormation = $DB->sqlFetch($sql);		
				
				$sql = "select num_grade, num_class, str_cafe_id, num_order FROM $Tab_Formation Where num_oid = ".$oid. " AND num_grade=$num_grade AND num_year='$school_year' order by num_order DESC";
				$forClass = $DB->sqlFetchAll($sql);		
				@array_walk($forClass,'cb_format_delete');								
				
				// 남은 학급 order 수정 
				if($orderFormation['count_class']>0){
					$sql = "Update " . $Tab_Formation . " Set num_order=num_order-".$orderFormation['count_class'] .
							" Where num_oid=$oid And num_year=$school_year And num_order> ".$orderFormation['max_order'];
					$DB->sqlQuery($sql);		
					if(!$DB->error) $DB->commit();	
				}
				
				// 학년삭제 
				$sql="DELETE FROM ".$Tab_Grade." WHERE num_oid=".$oid." AND num_grade = '$num_grade'";				
				$DB->sqlQuery($sql);
				$DB->commit();
				
				break;
				
			##	새로 만들기	
			case "add":								
				
				if(!$str_grade)WebApp::moveBack('추가할 학년을 입력하세요. - No.06');
				
				// 진급이 되는 학년인지 ( 0일경우 진급 연결, 1일경우 진급 불가 )
				if(!$promotion)$promotion=0;
						
				$maxGrade = ($DB->sqlFetchOne("select max(num_grade) from ".$Tab_Grade." where num_oid = ".$oid)+1);
				$preGrade = $maxGrade-1;
				
				// 30이하를 1-6학년으로 할당 예약, 추가학년은 30부터 시작
				if($maxGrade<30)$maxGrade=30;
				
				// 진급 추가시 기존진급순위 가장 하단에 추가
				//$getGrade = $DB->sqlFetchOne("select num_grade from ".$Tab_Grade." where num_oid = ".$oid." AND num_start_grade=0 AND num_next_grade is null AND rownum=1");				
				
				// 모두 입학학년일 경우 
				//if(!$getGrade)$getGrade=$preGrade;
				
				if(!$start_grade_num)$start_grade_num=1;



				
				if($promotion==0){
					//$sql = "select num_grade, str_grade, num_next_grade, num_start_grade from ".$Tab_Grade.		
					$sql = "select num_grade from ".$Tab_Grade.
					" where num_next_grade is null ".
					" connect by prior num_oid = num_oid And ".		
					" prior num_next_grade=num_grade ".
					" start with num_oid = ".$oid. " And num_grade=".$start_grade_num." And num_start_grade = 1 ";	
					$getGrade = $DB->sqlFetchOne($sql);			
					

					// 이전 진급학년과의 연결
					$sql = "UPDATE ".$Tab_Grade." set NUM_NEXT_GRADE = '".$maxGrade."' Where num_oid=".$oid." AND num_grade = ".$getGrade;				
					$DB->sqlQuery($sql); 								
				}
														
				$sql = "INSERT INTO ".$Tab_Grade."( NUM_OID,NUM_GRADE,STR_GRADE,NUM_NEXT_GRADE,NUM_START_GRADE ) ".
				" VALUES(".$oid.",'".$maxGrade."','".$str_grade."','".$num_next_grade."','".$promotion."')";		
				
				$DB->sqlQuery($sql); 																								 
				$DB->commit();
				break;

			##	수정시 
			case "update":
								
				$sql = "UPDATE ".$Tab_Grade." set str_grade = '".$str_grade."' Where num_oid=".$oid." AND num_grade = ".$num_grade;				
				$DB->sqlQuery($sql); 														
							
				$sql2 = "UPDATE ".$Tab_Formation." set str_grade = '".$str_grade."' Where num_oid=".$oid." AND num_grade = ".$num_grade;
				//if(getenv("REMOTE_ADDR")=="203.109.24.223") {echo $sql; exit;}
				$DB->sqlQuery($sql2);				
				$DB->commit();
				
				// 회원의 학급정보 수정
				$sql3 = "UPDATE tab_class_member set str_grade = '".$str_grade."' Where num_oid=".$oid." AND num_year=".$school_year." AND num_grade = ".$num_grade;
				$DB->sqlQuery($sql3);				
				$DB->commit();
				
				break;

			##	진급 관련 위치 수정 ▲ // 이전 진급 설정
			case "up":				
							
				$preGrade = $DB->sqlFetch("select num_grade, num_next_grade,num_start_grade from ".$Tab_Grade." where num_oid = ".$oid . " AND num_next_grade=".$num_grade);				
				$thisGrade = $DB->sqlFetch("select num_grade, num_next_grade from ".$Tab_Grade." where num_oid = ".$oid . " AND num_grade=".$num_grade);
												
				if(!$preGrade['num_grade'])WebApp::moveBack('학년순서의 시작입니다 - No.08');								
				//if($preGrade['num_start_grade']==1)WebApp::moveBack('입학학년은 변경할수 없습니다. - No.11');

				// 입학년도를 일반년도로 변경시
				if($preGrade['num_start_grade']==1){					
					$addStart=" , num_start_grade = 1";
					$delStart=" , num_start_grade = 0";
				}
								
				// 최 상위 grade 의 next grade 변경
				$sql = "UPDATE ".$Tab_Grade." set NUM_NEXT_GRADE = '".$num_grade."' Where num_oid=".$oid." AND num_next_grade = ".$preGrade['num_grade'];
				$DB->sqlQuery($sql); 				
				
				// 아래로 내릴 grade 의 next grade 변경
				$sql = "UPDATE ".$Tab_Grade." set NUM_NEXT_GRADE = '".$thisGrade['num_next_grade']."' " .$delStart. " Where num_oid=".$oid." AND num_grade = ".$preGrade['num_grade'];
				$DB->sqlQuery($sql); 				
				
				// 자신의 grade 의 next grade 변경
				$sql = "UPDATE ".$Tab_Grade." set NUM_NEXT_GRADE = '".$preGrade['num_grade']."' " .$addStart. " Where num_oid=".$oid." AND num_grade = ".$num_grade;
				$DB->sqlQuery($sql); 				

				// grade 가 중복일경우 rollback 시킬것. 

				$DB->commit();
				break;

			##	진급 관련 위치 수정 ▼ // 다음 진급 설정
			case "down":							

				$thisGrade = $DB->sqlFetch("select num_grade, num_next_grade, num_start_grade from ".$Tab_Grade." where num_oid = ".$oid . " AND num_grade=".$num_grade);
				if(!$thisGrade['num_next_grade'])WebApp::moveBack('학년순서의 끝 입니다 - No.09');								
				$nextGrade = $DB->sqlFetch("select num_grade, num_next_grade from ".$Tab_Grade." where num_oid = ".$oid . " AND num_grade=".$thisGrade['num_next_grade']);
				if(!$thisGrade['num_next_grade'])WebApp::moveBack('학년순서의 끝 입니다 - No.10');
				
				if($thisGrade['num_start_grade']==1){					
					$addStart=" , num_start_grade = 1";
					$delStart=" , num_start_grade = 0";
				}
				
				// 상위 grade 의 next grade 변경
				$sql = "UPDATE ".$Tab_Grade." set NUM_NEXT_GRADE = '".$thisGrade['num_next_grade']."' Where num_oid=".$oid." AND num_next_grade = ".$num_grade;				
				$DB->sqlQuery($sql); 				
												
				// 위로 올릴 grade 의 next grade 변경
				$sql = "UPDATE ".$Tab_Grade." set NUM_NEXT_GRADE = '".$num_grade."' ".$addStart." Where num_oid=".$oid." AND num_grade = ".$thisGrade['num_next_grade'];				
				$DB->sqlQuery($sql); 				
				
				// 아래로 내릴 grade 의 next grade 변경
				$sql = "UPDATE ".$Tab_Grade." set NUM_NEXT_GRADE = '".$nextGrade['num_next_grade']."' ".$delStart." Where num_oid=".$oid." AND num_grade = ".$num_grade;								
				$DB->sqlQuery($sql); 								

				// grade 가 중복일경우 rollback 시킬것. 

				$DB->commit();
				break;

			##	입학 학년 
			case "start":				

				// 이전 진학순서가 있으면 진학 학년을 졸업학년으로 						
				$sql = " UPDATE ".$Tab_Grade." set NUM_NEXT_GRADE = '' Where num_oid=".$oid." AND ".
				       " num_next_grade = ".$num_grade;
				$DB->sqlQuery($sql); 								
			
				// 현재 학년을 입학학년으로
				$sql = "UPDATE ".$Tab_Grade." set  NUM_START_GRADE=1 Where num_oid=".$oid." AND num_grade = ".$num_grade;
				$DB->sqlQuery($sql); 				
				$DB->commit();
				break;

			##	졸업 학년 
			case "end":		

				// 다음 진학순서가 있으면 진학 학년을 입학학년으로 						
				$sql = " UPDATE ".$Tab_Grade." set NUM_START_GRADE = 1 Where num_oid=".$oid." AND ".
				       " num_grade = (select num_next_grade from ".$Tab_Grade." Where num_oid=".$oid." AND ".  
				       " num_grade=".$num_grade.")";								       
				$DB->sqlQuery($sql); 								

				// 현재 학년을 졸업학년으로 						
				$sql = "UPDATE ".$Tab_Grade." set NUM_NEXT_GRADE = '' Where num_oid=".$oid." AND num_grade = ".$num_grade;				
				$DB->sqlQuery($sql); 				
				$DB->commit();
				break;


			default :				
		}		
			WebApp::moveBack('수정완료');

}

// 추후 진급학년을 선택하기 위한 select box ( 현재 기능 사용 안함 )
function cb_format_list(&$arr) {
	global $Tab_Grade,$oid,$DB;
			
		$next_grade = $DB->sqlFetchAll("SELECT num_grade,str_grade FROM ".$Tab_Grade." WHERE num_oid=". $oid);		
		
		if($arr['num_next_grade'])
			$arr['str_next_grade'] = "<option value=''>선택</option>";
		else
			$arr['str_next_grade'] = "<option value='' selected>선택</option>";

							
		foreach($next_grade as $row) {			
			if($arr['num_next_grade']== $row['num_grade'])
				$arr['str_next_grade'] .= "<option value='".$row['num_grade']."' selected>".$row['str_grade']."</option>";
			else
				$arr['str_next_grade'] .= "<option value='".$row['num_grade']."'>".$row['str_grade']."</option>";				
		}				
}

function cb_format_start_end(&$arr) {	
	global $Tab_Grade,$oid,$DB;				
		
		if($arr['num_grade']<30){
			$arr['view_delete_start'] = "<!--";
			$arr['view_delete_end'] = "-->";
		}		
		
		if($arr['num_start_grade']==1)
			$arr['str_start_end_grade'] = "<input type=radio name='str_start_end_grade' value='1' onclick=\"actionTo(this.form,'start','".$arr['num_grade']."')\" checked>입학<input type=radio name='str_start_end_grade' value='2'>일반<input type=radio name='str_start_end_grade' value='0' onclick=\"actionTo(this.form,'end','".$arr['num_grade']."')\">졸업";
		else
			if($arr['num_next_grade']=='')			
				$arr['str_start_end_grade'] = "<input type=radio name='str_start_end_grade' value='1' onclick=\"actionTo(this.form,'start','".$arr['num_grade']."')\">입학<input type=radio name='str_start_end_grade' value='2'>일반<input type=radio name='str_start_end_grade' value='0' checked onclick=\"actionTo(this.form,'end','".$arr['num_grade']."')\">졸업";
			else
				$arr['str_start_end_grade'] = "<input type=radio name='str_start_end_grade' value='1' onclick=\"actionTo(this.form,'start','".$arr['num_grade']."')\">입학<input type=radio name='str_start_end_grade' value='2' checked>일반<input type=radio name='str_start_end_grade' value='0' onclick=\"actionTo(this.form,'end','".$arr['num_grade']."')\">졸업";

}


function cb_format_delete(&$arr) {			
	global $Tab_Formation, $TAB_CLASS_MEMBER, $DB, $CafeDB, $oid, $school_year, $REMOTE_ADDR, $_OID;
	
	// $arr Parameter : num_grade, num_class, str_cafe_id, num_order	
	
				$pcode = $arr['str_cafe_id'];
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
				
				
				$FH = &WebApp::singleton('FileHost');
				$FH->delete_as_code('party',$pcode);
	
}
?>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                