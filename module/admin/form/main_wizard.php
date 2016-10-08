<?php
/*
	�ۼ� : Wes 
	�뵵 : �б��� �����ϰ� �����
	���� : 2007�� 02�� 08��
*/
$Tab_Formation 		= "TAB_FORMATION_SET";
$Tab_Formation_History 	= "TAB_FORMATION_HISTORY";
$Tab_Grade 		= "TAB_CLASS_GRADE";
$school_year = WebApp::getConf('formation.school_year');
$DB = &WebApp::singleton('DB');
		
switch ($REQUEST_METHOD) {
	case "GET":
		
		// ���� �г� ������ ������ �г����� ����� POPUP ��, â Close 
		$sql = "select count(num_oid) from ".$Tab_Grade." where num_oid = ".$oid;				
		$count_grade = $DB->sqlFetchOne($sql);
		if($count_grade==0){
			WebApp::alert('�г������� �����ϴ�. �켱 �г⸸���� �г��� ������ּ���.');
			WebApp::closeWin();
		}
				
		// History �� ���� �ش� �⵵
		$num_year = "<option>".$school_year."</option>";		
		
		// ���� ����� ������ ���� �б������� �����ϴ��� Ȯ��
		$sql = "select count(num_oid) from ".$Tab_Formation." where num_oid = ".$oid." AND num_year='".$school_year."'";		
		$is_empty = $DB->sqlFetchOne($sql);							
		if($is_empty>=1)$print_empty="������� ���� ���� �ִ� $is_empty ���� �б������� �����˴ϴ�. ";		
		
		// ���г⳻�� �ݰ���
		$print_class="<option value=''>����</option>";
		for($i=1;$i<30;$i++){
			$print_class .= "<option value='$i'>$i ��</option>";
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
				
		##	���� �б� ���� Backup �� ���� �б��� �����Ѵ�. ( data �� ip �߰� )						
		if(!$num_year)WebApp::moveBack('�ش�⵵�� �����ϴ�.');
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
		

		##	���� ������ â�� ����, ����. 


		##	���� �����
		$classSize = count($num_grade);
		if($classSize==0)WebApp::moveBack('���õ� �ݰ����� �����ϴ�.');
		$num_order = 1;
					

		##	������ â(�б� Ȩ��) ���� ���� ���� ī�� �����Ұ�. 
		$sql = "select str_cafe_id FROM $Tab_Formation Where num_oid = ".$oid. " AND num_year='$school_year'";					
		$forCafe = $DB->sqlFetchAll($sql);		
		


		$FH = &WebApp::singleton('FileHost');
		$_OID = _OID;
		for($ii=0; $ii<count($forCafe); $ii++) {
		
		$pcode = $forCafe[$ii][str_cafe_id];
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
		
		

		$FH->delete_as_code('party',$pcode);
		}
		
		$sql="DELETE FROM ".$Tab_Formation." WHERE num_oid=".$oid." AND num_year = '".$num_year."'";
		$DB->sqlQuery($sql); 
		$DB->commit();

		
		
		include _DOC_ROOT.'/module/party/cafe_add_lib.php';
		


		##	�б� ����					
		for( $i=0; $i < $classSize; $i++ ){
				
			$school_grade = "school_grade".$num_grade[$i];						
			if($$school_grade){
				
				for( $j=1; $j < ($$school_grade+1); $j++ ){
					
					$str_cafe_id = $num_year. sprintf("%02d",$num_grade[$i]) . sprintf("%02d",$j);
					$str_class = $j."��" ;
					
					$sql = "INSERT INTO ".$Tab_Formation."( NUM_OID,NUM_YEAR,NUM_GRADE,NUM_CLASS,STR_CAFE_ID,STR_GRADE,STR_CLASS,NUM_ORDER ) ".
					" VALUES(".$oid.",'".$num_year."','".$num_grade[$i]."','".$j."','".$str_cafe_id."','".$str_grade[$i]."','".$str_class."','".$num_order."')";
							
					$DB->sqlQuery($sql); 
					$DB->commit();
					
					
					// ������ â(�б� Ȩ��) ����...
					// ���� ī�� �����ϴ� ���� �־�� ��. **********************************************								
					

					$title = $str_class."";
					$cafe_memo = $str_class." �б�Ȩ�������Դϴ�.";
					$cate_type = "class";
					addCafe($str_cafe_id,$cate_type,$str_id,$title,$cafe_memo);
		
								
					$num_order++;
				}
			}
			
		}		
				
		echo "<script language='javascript'>alert('�б����� �Ϸ�Ǿ����ϴ�.');window.opener.document.location.reload();window.self.close();</script>";
}

function cb_format_list(&$arr) {			
	global  $oid;

}
?>