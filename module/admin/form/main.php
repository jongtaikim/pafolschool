<?php
/****************************************************
	작성 : 얼룩푸우(budget74@nate.com)
	용도 : 학급 편제 구성하기
	일자 : 2004년 02월 29일
	수정일 & 수정 내용
		2007-02-12 : 교실의 창 개편으로 인한 기존 체계 개편 작업 (by SR)
*****************************************************/

include _MODULE;

##	디비 접속
$DB = &WebApp::singleton('DB');



$_VARS = decodeVARS();
$check_new = $_GET['check_new'];
$school_year = WebApp::getConf('formation.school_year');
$last_year = $school_year -1;


switch ($REQUEST_METHOD) {
	case "GET":
			
			// 학년정보가 없을 경우 학급편성 시작 Page 를 보여주기
			$query = "select count(*) from ".TAB_CLASS_GRADE ." Where num_oid=$oid ";	
			$countGrade = $DB->sqlFetchOne($query);
					
			$tpl->setLayout('no4');
			if($countGrade <= 0){
				$tpl->define('CONTENT','html/admin/form/main_empty.htm');
		
				break;
			}	






		// 해당년도 학급정보가 없을 경우, 전년도 학급정보를 확인
		$query = "  SELECT
			(SELECT count(*) from ".TAB_FORMATION_SET ." Where num_oid=$oid and num_year=".$school_year.") c_current,
			(select count(*) from ".TAB_FORMATION_SET ." Where num_oid=$oid and num_year=".$school_year."-1 ) c_last
				FROM Dual";	
		$countClass = $DB->sqlFetch($query);
		if($countClass['c_current'] <= 0 && $countClass['c_last'] >0 && $check_new != 'Y'){
			$tpl->define('CONTENT','html/admin/form/main_choice.htm');
			$tpl->parse('CONTENT');
			break;
		}	


		$tpl->define('CONTENT','html/admin/form/main.htm');
	
		
		// 선생님 리스트
		$teacher_rank_list = "'t'";	// 기간제 강사 추가되면 "'t','l'";	// 강사:lecturer
		$query = "select str_id,  str_name from ".TAB_MEMBER." where num_oid = "._OID." and chr_mtype = 't' ";
		$teachers = $DB->sqlFetchAll($query);
		
		
		
		$nThisYear = date("Y");		
	
		$sql = "Select num_order, str_teacher, g.num_grade, num_class, g.str_grade, str_class, str_cafe_id, str_homepage
					 From (
						 Select rownum rnum, g.* from " . TAB_CLASS_GRADE . " g
						 Connect By Prior num_oid=num_oid And Prior num_next_grade=num_grade
						 Start with num_oid=$oid And num_start_grade=1
					) g
					 Left Outer Join " . TAB_FORMATION_SET . " f on g.num_oid=f.num_oid And g.num_grade=f.num_grade
					 And num_year=". $school_year .
					"  Order By rnum, num_order";
		$rows = $DB->sqlFetchAll($sql);		
		
		//echo $sql;

		$strWorkingGrade = $rows[0]['str_grade'];
		$nWorkingGrade = $rows[0]['num_grade'];
		$max_order = 0;
		


		for($ii=0; $ii<count($rows); $ii++) {
			$max_order = $rows[$ii]['num_order'] ? $rows[$ii]['num_order'] : $max_order;
			$blank_grade_order = $rows[$ii]['num_order'] ? 0 : $max_order + 1;

			
			if($strWorkingGrade != $rows[$ii]['str_grade']){
			
				$rows[$ii]['formation_grade'] = $strWorkingGrade;
				//$rows[$ii]['num_grade'] = $nWorkingGrade+1;
				$rows[$ii]['insert_order'] =  $blank_grade_order ? $blank_grade_order : $max_order;
				$ia = $ii -1;
				$rows[$ia]['add_class'] = "y";
	
				$strWorkingGrade = $rows[$ii]['str_grade'];
				$nWorkingGrade = $rows[$ii]['num_grade'];
			}else{
			
				$rows[$ii]['formation_grade'] = $strWorkingGrade;
				$rows[$ii]['num_grade'] = $nWorkingGrade;
				$rows[$ii]['insert_order'] =  $blank_grade_order ? $blank_grade_order : $max_order;
	
				
	
					
			}
		
			$bExistClass = true;
			if($rows[$ii]['num_class'] == ""){ $rows[$ii]['num_class']=-1; $bExistClass = false; }
			

			$rows[$ii]['formation_order'] = $rows[$ii]['num_order'];
			$rows[$ii]['num_grade'] = $rows[$ii]['num_grade'];
			$rows[$ii]['formation_grade'] =  $rows[$ii]['str_grade'] ;
			$rows[$ii]['num_class'] = $rows[$ii]['num_class'];
			$rows[$ii]['formation_class'] = $rows[$ii]['str_class'];
			$rows[$ii]['formation_use_cafe'] = $rows[$ii]['str_cafe_id'] || $rows[$ii]['str_homepage'] ? "O" : "X";

		
			

			$rows[$ii]['formation_teacher'] = $teachers;


			
			if($bExistClass) $rows[$ii]['manage_class'] = "y";
			$tpl->parse('DISPLAY_CLASS');
		}
		

		$tpl->assign(array('LIST'=>$rows));
		

		
		$max_order++;

		$tpl->assign(array('formation_grade'=> $strWorkingGrade));
		$tpl->assign(array('num_grade'=> $nWorkingGrade));
		$tpl->assign(array('insert_order'=>  $blank_grade_order ? $blank_grade_order : $max_order));

		$tpl->assign(array('school_year'=>$school_year));
		
		
	
		
		break;
	case "POST":

		
		$cache_file = _DOC_ROOT.'/hosts/'.HOST.'/'."inc.main.classObj.htm";
		 unlink($cache_file);

		$target_grade = $_POST['target_grade'];
		$target_class = $_POST['target_class'];
		switch($_POST['mode']){

			case "up":

				if(!$target_grade || !$target_class)WebApp::moveBack('학급관련 정보가 누락되었습니다.');				
					$sql= " 
						select * from
						(
							Select 					
								num_class, num_order from  ".TAB_FORMATION_SET."
							Where
								num_oid= ".$oid." And
								num_year = ".$school_year." And
								num_grade = ".$target_grade." And
								num_order < 
								(Select num_order from  ".TAB_FORMATION_SET."
								 Where 
									num_oid= ".$oid." And
									num_year = ".$school_year." And
									num_grade=".$target_grade." And
									num_class = ".$target_class."
							) 
							Order By num_order desc
						)
						where 
							rownum = 1";
					$up_order = $DB->sqlFetch($sql);	
								
					if(!$up_order)WebApp::moveBack('해당학년 학급순서의 처음입니다.');
					
					$sql = 	"UPDATE ".TAB_FORMATION_SET."
							set num_order =
								(Select num_order From 
									".TAB_FORMATION_SET."
								 Where 
									num_oid= ".$oid." And
									num_year = ".$school_year." And
									num_grade=".$target_grade." And
									num_class = ".$target_class."
								)								 
							 Where					
									num_oid= ".$oid." And
									num_year = ".$school_year." And
									num_grade=".$target_grade." And
									num_class=".$up_order['num_class']."";
					$DB->sqlQuery($sql);
					
					$sql = 	"UPDATE ".TAB_FORMATION_SET."
							set num_order =".$up_order['num_order']." 
							Where					
								num_oid= ".$oid." And
								num_year = ".$school_year." And
								num_grade=".$target_grade." And 
								num_class= ".$target_class."";											
					
					if ($DB->sqlQuery($sql)) $DB->commit();
					else $DB->disconnect();
					
				break;

			case "down":

				if(!$target_grade || !$target_class)WebApp::moveBack('학급관련 정보가 누락되었습니다.');				
					$sql= " 
						select * from
						(
							Select 					
								num_class, num_order from  ".TAB_FORMATION_SET."
							Where
								num_oid= ".$oid." And
								num_year = ".$school_year." And
								num_grade = ".$target_grade." And
								num_order > 
								(Select num_order from  ".TAB_FORMATION_SET."
								 Where 
									num_oid= ".$oid." And
									num_year = ".$school_year." And
									num_grade=".$target_grade." And
									num_class = ".$target_class."
							) 
							Order By num_order asc
						)
						where 
							rownum = 1";
					$down_order = $DB->sqlFetch($sql);	
								
					if(!$down_order)WebApp::moveBack('해당학년 학급순서의 마지막입니다.');
					
					$sql = 	"UPDATE ".TAB_FORMATION_SET."
							set num_order =
								(Select num_order From 
									".TAB_FORMATION_SET."
								 Where 
									num_oid= ".$oid." And
									num_year = ".$school_year." And
									num_grade=".$target_grade." And
									num_class = ".$target_class."
								)								 
							 Where					
									num_oid= ".$oid." And
									num_year = ".$school_year." And
									num_grade=".$target_grade." And
									num_class=".$down_order['num_class']."";
					$DB->sqlQuery($sql);
					
					$sql = 	"UPDATE ".TAB_FORMATION_SET."
							set num_order =".$down_order['num_order']." 
							Where					
								num_oid= ".$oid." And
								num_year = ".$school_year." And
								num_grade=".$target_grade." And 
								num_class= ".$target_class."";											
					
					if ($DB->sqlQuery($sql)) $DB->commit();
					else $DB->disconnect();
					
				break;

			case "write":
	
			 
			 
				$grade_name = $_POST['grade_name'];
				$class_name = $_POST['class_name'];
				$insert_order = $_POST['new_order'];
				$sql = "Select nvl(Max(num_class), 0) + 1 as new_class From " . TAB_FORMATION_SET .
							" Where num_oid=$oid And num_year=$school_year And num_grade=$target_grade";
				$nClassNum = $DB->sqlFetchOne($sql);
				
				$sql = "Update " . TAB_FORMATION_SET . " Set num_order=num_order+1" . 
						" Where num_oid=$oid And num_year=".$school_year." And num_order>=" . $insert_order;
				$DB->sqlQuery($sql);
				if(!$DB->error) $DB->commit();
				
				$sql = "Insert Into " .TAB_FORMATION_SET . 
							"(num_oid,num_year,num_grade,num_class,num_order," . 
							"str_grade,str_class,str_cafe_id,str_homepage)" .
						" Values($oid, $school_year, $target_grade, $nClassNum, $insert_order," .
							" '".$grade_name."', '".$class_name."', '','')";
				
				$DB->sqlQuery($sql);
				if(!$DB->error) $DB->commit();
				
				// 교실의 창(학급 홈피) 생성...
				// 실제 카페 생성하는 구문 넣어야 함. **********************************************
				$strPartCode = sprintf("%04d%02d%02d", $school_year, $target_grade, $nClassNum);
				
				include _DOC_ROOT.'/module/party/cafe_add_lib.php';
				
				if($grade_name == $class_name){
					$title = $class_name;
					$cafe_memo = $class_name." 학급홈페이지입니다.";
				}else{
					$title = $grade_name." ".$class_name;
					$cafe_memo = $grade_name." ".$class_name." 학급홈페이지입니다.";
				}
				$cate_type = "class";
				addCafe($strPartCode,$cate_type,$str_id,$title,$cafe_memo);
		
				
				
				$sql = "Update " . TAB_FORMATION_SET . " Set Str_Cafe_ID='".$strPartCode."'" .
						" Where num_oid=$oid And num_year=$school_year And num_grade=$target_grade And num_class=$nClassNum";
				$DB->sqlQuery($sql);
				if(!$DB->error) $DB->commit();

				// 학급정보 변경 기록
				put_form_history($target_grade, $nClassNum, 'write');

				break;
			case "modify":
				$class_name = $_POST['class_name'];
				$teacherID = $_POST['teacherID'];		// 새로 고친 담임 선생님
				$class_teacher = $_POST['class_teacher'];	// 원래 입력돼 있던 선생님
				
	
				
				

				$sql = "Select str_class From " . TAB_FORMATION_SET .
							" Where num_oid=$oid And num_year=$school_year And num_grade=$target_grade and num_class=$target_class";
				$DiffClass = $DB->sqlFetchOne($sql);
				
				
				$strPartCode = sprintf("%04d%02d%02d", $school_year, $target_grade, $target_class);
				$pcode = $strPartCode;
				
				if($grade_name == $class_name){
					$title = $class_name;
					$cafe_memo = $class_name." 학급홈페이지입니다.";
					$ptitle =$class_name;
				}else{
					$title = $grade_name." ".$class_name;
					$cafe_memo = $grade_name." ".$class_name." 학급홈페이지입니다.";
					$ptitle = $grade_name." ".$class_name;
				}

				
				
		
				if($DiffClass!=$class_name){
					
					// 학급정보 변경전 기록
					put_form_history($target_grade, $target_class, 'modify');

				
				}
					// 회원의 학급정보 수정
					$sqlc = "UPDATE TAB_PARTY set str_pname = '".$ptitle."'  , cafe_memo = '".$cafe_memo."' Where num_oid=".$oid." AND num_pcode=".$strPartCode;
					;

					$DB->sqlQuery($sqlc);				
					$DB->commit();		
				
			
				

				// 학급 명칭 수정
				$sql = "Update " . TAB_FORMATION_SET . " Set str_class='" . $class_name . "'" .
							"  Where num_oid=".$oid." And num_year=".$school_year.
								" And num_grade=".$target_grade." And num_class=".$target_class;
				$DB->sqlQuery($sql);
				if(!$DB->error) $DB->commit();
				
				// 담임 선생님이 바뀌지 않았으면 pass
				if($teacherID == $class_teacher) break;
				
				
				if($teacherID != "nobody"){
					$grade_name = $_POST['grade_name'];

				$sql = "delete from TAB_PARTY_MEMBER where num_oid = "._OID." AND num_pcode=".$strPartCode." and str_id = '".$class_teacher."'";
				$DB->query($sql);
				$DB->commit();

	
	
			
				$sql = "Insert into TAB_PARTY_MEMBER
				   (NUM_OID, NUM_PCODE, STR_ID, STR_MTYPE,  STR_IP, STR_DATE)
				 Values
				   ("._OID.", $pcode, '".$teacherID."', 'a',  '".$_SERVER[REMOTE_ADDR]."', '".mktime()."' )";
				$DB->query($sql);
				$DB->commit();

			
				// 해당년도 학급 담임 기록 입력
				$sql = "Update " . TAB_FORMATION_SET . " Set str_teacher='$teacherID'" ." Where num_oid=".$oid." And num_year=".$school_year.
								" And num_grade=".$target_grade." And num_class=".$target_class;

				$DB->sqlQuery($sql);
				if(!$DB->error) $DB->commit();

				// 해당년도 학급 담임 기록 입력
				$sql = "Update " . TAB_PARTY . " Set str_id='$teacherID'" ." Where num_oid=".$oid." AND num_pcode=".$strPartCode;
				$DB->sqlQuery($sql);
				if(!$DB->error) $DB->commit();
					
				}
				
		
				break;
			case "delete":
				$del_order = $_POST['del_order'];
				
				$sql = "Select str_cafe_id From " . TAB_FORMATION_SET .
						" Where num_oid=$oid And num_year=$school_year And num_grade=$target_grade And num_class=$target_class";
				$strCafeID = $DB->sqlFetchOne($sql);
				

				// 학급정보 삭제전 기록
				put_form_history($target_grade, $target_class, 'del');
				
				$sql = "Delete " . TAB_FORMATION_SET .
						" Where num_oid=$oid And num_year=$school_year And num_grade=$target_grade And num_class=$target_class";
				$DB->sqlQuery($sql);
				if(!$DB->error) $DB->commit();
				
				$sql = "Update " . TAB_FORMATION_SET . " Set num_order=num_order-1" .
						" Where num_oid=$oid And num_year=$school_year And num_order>$del_order";
				$DB->sqlQuery($sql);
				if(!$DB->error) $DB->commit();
				
				// 카페(학급 홈피)도 삭제하는지...
				// _MEMBER_RANK에서 카페 권한 삭제.
				// _CAFE 에서 카페 정보 삭제
				// _CAFE_BOARD에서 board삭제....
				// 음.... 이거 모듈 불러와서 해야 겠군...
				
				$strPartCode = sprintf("%04d%02d%02d", $school_year, $target_grade, $target_class);

				$pcode = $strCafeID;
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



				break;
		}
		
		//==-- 기존 캐시파일 지우기 --==//
		//*********임시로 주석 처리******//include "module/admin/inc.ftpsave.php";
//		if (!ftpdel("school/hosts/$HOST/inc.classlist.htm")) WebApp::alert('캐시파일 비우기 오류');
		//*********임시로 주석 처리******//ftpdel("school/hosts/$HOST/inc.classlist.htm");
		
//		if( $parent ) $_VARS[act] .= "&parent=".$parent;
		
		ReturnUrl("?act=".$_VARS[act]);
		break;		// end of [case "POST":]
}
function make_teacher_select($nGrade, $nClass, $teacher_id){
	GLOBAL $teachers;
	
	$tempArray;
	$tempTeacher="";


	
	for($i=0; $i<count($teachers); $i++){
		if($tempTeacher==$teachers[$i]['str_name']){
			$tempArray[$i-1][0] = 1;
			$tempArray[$i-1][1] = $teachers[$i-1]['str_name'];
			$tempArray[$i-1][2] = $teachers[$i-1]['str_id'];
			$tempArray[$i-1][3] = substr($teachers[$i-1]['str_logonid'],0,8);
			$tempArray[$i][0] = 1;
			$tempArray[$i][1] = $teachers[$i]['str_name'];
			$tempArray[$i][2] = $teachers[$i]['str_id'];
			$tempArray[$i][3] = substr($teachers[$i]['str_logonid'],0,8);
		}else{
			$tempArray[$i][0] = 0;
			$tempArray[$i][1] = $teachers[$i]['str_name'];
			$tempArray[$i][2] = $teachers[$i]['str_id'];
			$tempArray[$i][3] = substr($teachers[$i]['str_logonid'],0,8);
		}
		$tempTeacher = $teachers[$i]['str_name'];
		
	}

	$result = "<select name='teacher_id'>\n" .
					"\t\t\t\t\t\t\t<option value='nobody'>&nbsp;</option>\n";
	for($i=0;$i<count($tempArray);$i++){		
		$result.= "\t\t\t\t\t\t\t<option value='".$tempArray[$i][2]."'";
		if($tempArray[$i][2] == $teacher_id) $result.= " selected";

		if($tempArray[$i][0]==1){
			$result.= ">".$tempArray[$i][1]."(".$tempArray[$i][3]."....)</option>\n";
		}else{
			$result.= ">".$tempArray[$i][1]."</option>\n";		
		}
	}
	$result .= "\t\t\t\t\t\t\t</select>";
	return $result;
}

function put_form_history($grade, $class, $mode){
	global $DB, $oid, $school_year, $REMOTE_ADDR;

		$InsertSql = "	
			Insert Into TAB_FORMATION_HISTORY(
			  NUM_OID,
			  NUM_YEAR,
			  NUM_GRADE,
			  NUM_CLASS,
			  NUM_ORDER,
			  STR_GRADE,
			  STR_CLASS,
			  STR_CAFE_ID,
			  STR_HOMEPAGE,
			  STR_TEACHER,
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
			  '$mode',
			  STR_TEACHER,
			  SYSDATE,
			  '$REMOTE_ADDR'
			From TAB_FORMATION_SET where num_oid = ".$oid." AND num_year='".$school_year."' AND num_grade=$grade AND num_class=$class";
		$DB->sqlQuery($InsertSql); 
		$DB->commit();		
}
?>