<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2009-07-14
* �ۼ���: ������
* ��   ��: �̿����� �г⸸��� ��� ���ø� ����� ������
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

		// ������ �г��� ���� ��� ��Page ���� ���õ� ��,��,�� ���� Default �� �г��� �־��ٰ�.
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
			
			// �����г� �ʱ�ȭ 
			if($i==1)
				$num_start_grade=1;
			else
				$num_start_grade=0;
				
			$sql = "INSERT INTO ".$Tab_Grade."( NUM_OID,NUM_GRADE,STR_GRADE,NUM_NEXT_GRADE,NUM_START_GRADE) ".
			" VALUES(".$oid.",'".$i."','".$i."�г�','".$next_grade."','".$num_start_grade."')";
			$DB->sqlQuery($sql); 
			$DB->commit();				
		}			
						
					
		// ���� ����б� �г����� 1-6�г��� �ʱ� ���� (num_grade 1-6 ���� ���) 7-29������ ���޿�
		// ���� �����ϴ� �г����� - Ư���г� Ȥ�� ���� (num_grade 30 - 99 ���� )												
		$array_dot = split("\.", $REMOTE_ADDR);
		$ipbase = $array_dot[0].".".$array_dot[1].".".$array_dot[2];		
		
		
		
		
		
		
		// E-Wut.com ���� IP�ΰ�� ������ HTML ������
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


		// E-Wut.com ���� IP �� �ƴ� ��쿡 ���� HTML ������
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
				
			##	������						
			case "del":
							
				$preGrade = $DB->sqlFetch("select num_grade, num_next_grade,num_start_grade from ".$Tab_Grade." where num_oid = ".$oid . " AND num_next_grade=".$num_grade);				
				$nextGrade = $DB->sqlFetch("select num_grade, num_next_grade from ".$Tab_Grade." where num_oid = ".$oid ." AND num_grade=".
						" (select num_next_grade from ".$Tab_Grade." Where num_oid=".$oid." AND num_grade=".$num_grade.")");
				
				if($preGrade['num_grade']){
					// ������ �������ް� ����Ǿ� �ְ� ���� ������ ���� ���  ��� �г��� �����Ǹ� �� ������ ����
					if($nextGrade['num_grade']){
						$sql = "UPDATE ".$Tab_Grade." set NUM_NEXT_GRADE = '".$nextGrade['num_grade']."' Where num_oid=".$oid." AND num_grade = ".$preGrade['num_grade'];
						$DB->sqlQuery($sql);
					// ������ �������ް� ����Ǿ� �ְ� ���� ������ ������� �г��� �����Ǹ� ���� ������ �����г����� ����						
					}else{
						$sql = "UPDATE ".$Tab_Grade." set NUM_NEXT_GRADE = '' Where num_oid=".$oid." AND num_grade = ".$preGrade['num_grade'];
						$DB->sqlQuery($sql);					
					}
				}else{
					$sql = "UPDATE ".$Tab_Grade." set NUM_START_GRADE = 1 Where num_oid=".$oid." AND num_grade = ".$nextGrade['num_grade'];
					$DB->sqlQuery($sql);									
				}
				
				// �г��� ������ �г����Ͽ� �ִ� �б� ������ ī�� ����
							
		

				$sql = "select count(num_class) count_class, max(num_order) max_order FROM $Tab_Formation Where num_oid = ".$oid. " AND num_grade=$num_grade AND num_year='$school_year'";
				$orderFormation = $DB->sqlFetch($sql);		
				
				$sql = "select num_grade, num_class, str_cafe_id, num_order FROM $Tab_Formation Where num_oid = ".$oid. " AND num_grade=$num_grade AND num_year='$school_year' order by num_order DESC";
				$forClass = $DB->sqlFetchAll($sql);		
				@array_walk($forClass,'cb_format_delete');								
				
				// ���� �б� order ���� 
				if($orderFormation['count_class']>0){
					$sql = "Update " . $Tab_Formation . " Set num_order=num_order-".$orderFormation['count_class'] .
							" Where num_oid=$oid And num_year=$school_year And num_order> ".$orderFormation['max_order'];
					$DB->sqlQuery($sql);		
					if(!$DB->error) $DB->commit();	
				}
				
				// �г���� 
				$sql="DELETE FROM ".$Tab_Grade." WHERE num_oid=".$oid." AND num_grade = '$num_grade'";				
				$DB->sqlQuery($sql);
				$DB->commit();
				
				break;
				
			##	���� �����	
			case "add":								
				
				if(!$str_grade)WebApp::moveBack('�߰��� �г��� �Է��ϼ���. - No.06');
				
				// ������ �Ǵ� �г����� ( 0�ϰ�� ���� ����, 1�ϰ�� ���� �Ұ� )
				if(!$promotion)$promotion=0;
						
				$maxGrade = ($DB->sqlFetchOne("select max(num_grade) from ".$Tab_Grade." where num_oid = ".$oid)+1);
				$preGrade = $maxGrade-1;
				
				// 30���ϸ� 1-6�г����� �Ҵ� ����, �߰��г��� 30���� ����
				if($maxGrade<30)$maxGrade=30;
				
				// ���� �߰��� �������޼��� ���� �ϴܿ� �߰�
				//$getGrade = $DB->sqlFetchOne("select num_grade from ".$Tab_Grade." where num_oid = ".$oid." AND num_start_grade=0 AND num_next_grade is null AND rownum=1");				
				
				// ��� �����г��� ��� 
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
					

					// ���� �����г���� ����
					$sql = "UPDATE ".$Tab_Grade." set NUM_NEXT_GRADE = '".$maxGrade."' Where num_oid=".$oid." AND num_grade = ".$getGrade;				
					$DB->sqlQuery($sql); 								
				}
														
				$sql = "INSERT INTO ".$Tab_Grade."( NUM_OID,NUM_GRADE,STR_GRADE,NUM_NEXT_GRADE,NUM_START_GRADE ) ".
				" VALUES(".$oid.",'".$maxGrade."','".$str_grade."','".$num_next_grade."','".$promotion."')";		
				
				$DB->sqlQuery($sql); 																								 
				$DB->commit();
				break;

			##	������ 
			case "update":
								
				$sql = "UPDATE ".$Tab_Grade." set str_grade = '".$str_grade."' Where num_oid=".$oid." AND num_grade = ".$num_grade;				
				$DB->sqlQuery($sql); 														
							
				$sql2 = "UPDATE ".$Tab_Formation." set str_grade = '".$str_grade."' Where num_oid=".$oid." AND num_grade = ".$num_grade;
				//if(getenv("REMOTE_ADDR")=="203.109.24.223") {echo $sql; exit;}
				$DB->sqlQuery($sql2);				
				$DB->commit();
				
				// ȸ���� �б����� ����
				$sql3 = "UPDATE tab_class_member set str_grade = '".$str_grade."' Where num_oid=".$oid." AND num_year=".$school_year." AND num_grade = ".$num_grade;
				$DB->sqlQuery($sql3);				
				$DB->commit();
				
				break;

			##	���� ���� ��ġ ���� �� // ���� ���� ����
			case "up":				
							
				$preGrade = $DB->sqlFetch("select num_grade, num_next_grade,num_start_grade from ".$Tab_Grade." where num_oid = ".$oid . " AND num_next_grade=".$num_grade);				
				$thisGrade = $DB->sqlFetch("select num_grade, num_next_grade from ".$Tab_Grade." where num_oid = ".$oid . " AND num_grade=".$num_grade);
												
				if(!$preGrade['num_grade'])WebApp::moveBack('�г������ �����Դϴ� - No.08');								
				//if($preGrade['num_start_grade']==1)WebApp::moveBack('�����г��� �����Ҽ� �����ϴ�. - No.11');

				// ���г⵵�� �Ϲݳ⵵�� �����
				if($preGrade['num_start_grade']==1){					
					$addStart=" , num_start_grade = 1";
					$delStart=" , num_start_grade = 0";
				}
								
				// �� ���� grade �� next grade ����
				$sql = "UPDATE ".$Tab_Grade." set NUM_NEXT_GRADE = '".$num_grade."' Where num_oid=".$oid." AND num_next_grade = ".$preGrade['num_grade'];
				$DB->sqlQuery($sql); 				
				
				// �Ʒ��� ���� grade �� next grade ����
				$sql = "UPDATE ".$Tab_Grade." set NUM_NEXT_GRADE = '".$thisGrade['num_next_grade']."' " .$delStart. " Where num_oid=".$oid." AND num_grade = ".$preGrade['num_grade'];
				$DB->sqlQuery($sql); 				
				
				// �ڽ��� grade �� next grade ����
				$sql = "UPDATE ".$Tab_Grade." set NUM_NEXT_GRADE = '".$preGrade['num_grade']."' " .$addStart. " Where num_oid=".$oid." AND num_grade = ".$num_grade;
				$DB->sqlQuery($sql); 				

				// grade �� �ߺ��ϰ�� rollback ��ų��. 

				$DB->commit();
				break;

			##	���� ���� ��ġ ���� �� // ���� ���� ����
			case "down":							

				$thisGrade = $DB->sqlFetch("select num_grade, num_next_grade, num_start_grade from ".$Tab_Grade." where num_oid = ".$oid . " AND num_grade=".$num_grade);
				if(!$thisGrade['num_next_grade'])WebApp::moveBack('�г������ �� �Դϴ� - No.09');								
				$nextGrade = $DB->sqlFetch("select num_grade, num_next_grade from ".$Tab_Grade." where num_oid = ".$oid . " AND num_grade=".$thisGrade['num_next_grade']);
				if(!$thisGrade['num_next_grade'])WebApp::moveBack('�г������ �� �Դϴ� - No.10');
				
				if($thisGrade['num_start_grade']==1){					
					$addStart=" , num_start_grade = 1";
					$delStart=" , num_start_grade = 0";
				}
				
				// ���� grade �� next grade ����
				$sql = "UPDATE ".$Tab_Grade." set NUM_NEXT_GRADE = '".$thisGrade['num_next_grade']."' Where num_oid=".$oid." AND num_next_grade = ".$num_grade;				
				$DB->sqlQuery($sql); 				
												
				// ���� �ø� grade �� next grade ����
				$sql = "UPDATE ".$Tab_Grade." set NUM_NEXT_GRADE = '".$num_grade."' ".$addStart." Where num_oid=".$oid." AND num_grade = ".$thisGrade['num_next_grade'];				
				$DB->sqlQuery($sql); 				
				
				// �Ʒ��� ���� grade �� next grade ����
				$sql = "UPDATE ".$Tab_Grade." set NUM_NEXT_GRADE = '".$nextGrade['num_next_grade']."' ".$delStart." Where num_oid=".$oid." AND num_grade = ".$num_grade;								
				$DB->sqlQuery($sql); 								

				// grade �� �ߺ��ϰ�� rollback ��ų��. 

				$DB->commit();
				break;

			##	���� �г� 
			case "start":				

				// ���� ���м����� ������ ���� �г��� �����г����� 						
				$sql = " UPDATE ".$Tab_Grade." set NUM_NEXT_GRADE = '' Where num_oid=".$oid." AND ".
				       " num_next_grade = ".$num_grade;
				$DB->sqlQuery($sql); 								
			
				// ���� �г��� �����г�����
				$sql = "UPDATE ".$Tab_Grade." set  NUM_START_GRADE=1 Where num_oid=".$oid." AND num_grade = ".$num_grade;
				$DB->sqlQuery($sql); 				
				$DB->commit();
				break;

			##	���� �г� 
			case "end":		

				// ���� ���м����� ������ ���� �г��� �����г����� 						
				$sql = " UPDATE ".$Tab_Grade." set NUM_START_GRADE = 1 Where num_oid=".$oid." AND ".
				       " num_grade = (select num_next_grade from ".$Tab_Grade." Where num_oid=".$oid." AND ".  
				       " num_grade=".$num_grade.")";								       
				$DB->sqlQuery($sql); 								

				// ���� �г��� �����г����� 						
				$sql = "UPDATE ".$Tab_Grade." set NUM_NEXT_GRADE = '' Where num_oid=".$oid." AND num_grade = ".$num_grade;				
				$DB->sqlQuery($sql); 				
				$DB->commit();
				break;


			default :				
		}		
			WebApp::moveBack('�����Ϸ�');

}

// ���� �����г��� �����ϱ� ���� select box ( ���� ��� ��� ���� )
function cb_format_list(&$arr) {
	global $Tab_Grade,$oid,$DB;
			
		$next_grade = $DB->sqlFetchAll("SELECT num_grade,str_grade FROM ".$Tab_Grade." WHERE num_oid=". $oid);		
		
		if($arr['num_next_grade'])
			$arr['str_next_grade'] = "<option value=''>����</option>";
		else
			$arr['str_next_grade'] = "<option value='' selected>����</option>";

							
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
			$arr['str_start_end_grade'] = "<input type=radio name='str_start_end_grade' value='1' onclick=\"actionTo(this.form,'start','".$arr['num_grade']."')\" checked>����<input type=radio name='str_start_end_grade' value='2'>�Ϲ�<input type=radio name='str_start_end_grade' value='0' onclick=\"actionTo(this.form,'end','".$arr['num_grade']."')\">����";
		else
			if($arr['num_next_grade']=='')			
				$arr['str_start_end_grade'] = "<input type=radio name='str_start_end_grade' value='1' onclick=\"actionTo(this.form,'start','".$arr['num_grade']."')\">����<input type=radio name='str_start_end_grade' value='2'>�Ϲ�<input type=radio name='str_start_end_grade' value='0' checked onclick=\"actionTo(this.form,'end','".$arr['num_grade']."')\">����";
			else
				$arr['str_start_end_grade'] = "<input type=radio name='str_start_end_grade' value='1' onclick=\"actionTo(this.form,'start','".$arr['num_grade']."')\">����<input type=radio name='str_start_end_grade' value='2' checked>�Ϲ�<input type=radio name='str_start_end_grade' value='0' onclick=\"actionTo(this.form,'end','".$arr['num_grade']."')\">����";

}


function cb_format_delete(&$arr) {			
	global $Tab_Formation, $TAB_CLASS_MEMBER, $DB, $CafeDB, $oid, $school_year, $REMOTE_ADDR, $_OID;
	
	// $arr Parameter : num_grade, num_class, str_cafe_id, num_order	
	
				$pcode = $arr['str_cafe_id'];
				// MENU Module DB ����
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
				//2009-04-14 ���� ����� ����
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