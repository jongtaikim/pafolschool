<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2009-08-28
* 작성자: 김종태
* 설   명: 메뉴이동
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');
$URL = &WebApp::singleton('WebAppURL');






/******  메뉴순서변경 ********/

	if($saveString){
	
	$items = explode(",",$saveString);
	for($no=0;$no<count($items);$no++){
		$tokens = explode("-",$items[$no]);

		
		$tokenss = substr($tokens[0],0,strlen($tokens[0])-2);
		
		
		
		echo $tokens[0]." / ".$tokens[1]."<br>";
		echo "ID: ".$tokens[0]. " is sub of ".$tokens[1]." = ".$new_mcode."<br>";	// Just for testing
		if( $tokenss != $tokens[1]  ){

		
		

		if(strlen($tokens[1]) ==  strlen($tokens[0]) ){
			//$new_mcode = $tokens[1].$tokens[0];
			
			$sql = "select max(num_cate) from TAB_MENU where num_oid = $_OID and num_cate like '".$tokens[1]."__' ";
			$new_mcode = $DB -> sqlFetchOne($sql);
			if(!$new_mcode) $new_mcode = $tokens[1]."10";
		
		}else{
		$new_mcode = $tokens[1].substr($tokens[0],strlen($tokens[0])-2,2);
		}
		
		
		if($tokens[1] == 0)  {
				if(strlen($tokens[0]) > 2){
					$sql = "select max(num_cate) from TAB_MENU WHERE num_oid="._OID." AND LENGTH(num_cate)=2  ";
					$new_mcode = $DB -> sqlFetchOne($sql)+1;
					
				}else{
					$new_mcode = $tokens[0];
				}
		}	

		echo "ID: ".$tokens[0]. " is sub of ".$tokens[1]." = ".$new_mcode."<br>";	// Just for testing
		
/*		$sql = "select num_cate from TAB_MENU where num_oid = $_OID and num_cate like '".$tokens[1]."__' ";
		$prow = $DB -> sqlFetchAll($sql);
		for($i=0; $i<count($prow); $i++) {
		
				$p_cate = $prow[$i][num_cate] + 1;
				 $sql = "UPDATE ".TAB_MENU." SET num_cate=".$p_cate." WHERE num_oid=$_OID and num_cate = ".$prow[$i][num_cate]."";
				 $DB->query($sql);
		}*/
		
		
		
		$sql = "select max(num_cate) from TAB_MENU where num_oid = $_OID and num_cate like '".$tokens[1]."__' ";
		$new_mcode_max = $DB -> sqlFetchOne($sql) ;
		
		if($new_mcode_max >= $new_mcode){
			$new_mcode = $new_mcode_max +1;

		}
		

		
		
		
		
			/*$sql = "select min(num_step) from TAB_MENU where num_oid = $_OID and num_cate like '".$tokens[1]."__' ";
			$new_mcode_min = $DB -> sqlFetchOne($sql) ;
			$new_mcode_min = $new_mcode_min -1;*/
			$ppsql = ", num_step = 0";
		

		
	if($new_mcode !=$tokens[0]){

		//2009-09-03 종태 변경하자
		 $sql = "UPDATE ".TAB_MENU." SET num_cate=".$new_mcode."  $ppsql  WHERE num_oid=$_OID and num_cate = ".$tokens[0]."";
		echo "<font color=red>".$sql."</font><br>";
		$DB->query($sql);
		
		$_SESSION[ses_cate] .= substr($new_mcode,0,strlen($new_mcode)-2)."|";


		//2009-09-03 종태 기존 번호 재정렬
		$sql = "select num_cate from TAB_MENU where num_oid = $_OID and num_cate like '".substr($new_mcode,0,strlen($new_mcode)-2)."__' order by num_step";
			
			$orderby = $DB -> sqlFetchAll($sql);

				
				for($iq=0; $iq<count($orderby); $iq++) {
				
					$iqa = $iq+1;
					 $sql = "UPDATE ".TAB_MENU." SET num_step=".$iqa." WHERE num_oid=$_OID and num_cate = ".$orderby[$iq][num_cate]."";
					//echo "<font color=red>".$sql."</font><br>";
					$DB->query($sql);
					
				}
		
		

		//2009-09-03 종태 기존 번호 재정렬
		$sql = "select num_cate from TAB_MENU where num_oid = $_OID and num_cate like '".substr($tokens[0],0,strlen($tokens[0])-2)."__' order by num_step";
			
			$orderby = $DB -> sqlFetchAll($sql);

				
				for($iq=0; $iq<count($orderby); $iq++) {
				
					$iqa = $iq+1;
					 $sql = "UPDATE ".TAB_MENU." SET num_step=".$iqa." WHERE num_oid=$_OID and num_cate = ".$orderby[$iq][num_cate]."";
					//echo "<font color=red>".$sql."</font><br>";
					$DB->query($sql);
					
				}
		
		
		
		//2009-09-03 하위도 변경하자
		$sql = "select num_cate from TAB_MENU where num_oid = $_OID and num_cate like '".$tokens[0]."__' ";
		$row = $DB -> sqlFetchAll($sql);

			for($ii=0; $ii<count($row); $ii++) {
						$new_mcode2 = $new_mcode.substr($row[$ii][num_cate],strlen($row[$ii][num_cate])-2,2);

						 $sql = "UPDATE ".TAB_MENU." SET num_cate=".$new_mcode2." WHERE num_oid=$_OID and num_cate = ".$row[$ii][num_cate]."";
						//echo "&nbsp;&nbsp;".$sql."<br><br>";
						 $DB->query($sql);

			}
		}
		}

	}
	 $DB->commit();
	 exec("rm -rf "._DOC_ROOT."/hosts/".HOST."/inc_menu/*.htm");
	 exec("rm -rf "._DOC_ROOT."/hosts/".HOST."/menu.xml");
	//WebApp::moveBack();
	
	 
	 exit;
	}

/******  메뉴순서 끝 변경 ********/






			$ni = 0;
			$sql = "SELECT /*+ INDEX(".TAB_MENU." ".IDX_TAB_MENU_INDEX.") */ * FROM ".TAB_MENU." ".
			"WHERE num_oid="._OID." AND LENGTH(num_cate)=2  $que   ORDER BY num_step";

			if($data = $DB->sqlFetchAll($sql)) {

				$total = count($data);
				$tpl->assign(array('total_sub_menu'=>$total));

				
				for($ii=0; $ii<count($data); $ii++) {
					$ni++;
					$data[$ii][num] = $ni;
					list($module_name,$module_type) = explode('#',$data[$ii]['str_type']);
					
					$data[$ii]['cate_2'] = substr($data[$ii]['num_cate'],0,strlen($data[$ii]['num_cate'])-2)."|";
					


					if(strlen($data[$ii]['num_cate']) <= 5) {

						$sql = "SELECT /*+ INDEX(".TAB_MENU." ".IDX_TAB_MENU_INDEX.") */ * FROM ".TAB_MENU." WHERE ".
						"num_oid="._OID." AND num_cate LIKE '".$data[$ii]['num_cate']."__'  ORDER BY num_step";

						if($data_sub =  $DB->sqlFetchAll($sql)) {

							for($i=0; $i<count($data_sub); $i++) {
								$ni++;
								$data_sub[$i][num] = $ni;
								$data_sub[$i]['cate_2'] = substr($data_sub[$i]['num_cate'],0,strlen($data_sub[$i]['num_cate'])-2)."|";

							$sql = "SELECT /*+ INDEX(".TAB_MENU." ".IDX_TAB_MENU_INDEX.") */ * FROM ".TAB_MENU." WHERE ".
							"num_oid="._OID." AND num_cate LIKE '".$data_sub[$i]['num_cate']."__'  ORDER BY num_step";

							if($data_sub_sub =  $DB->sqlFetchAll($sql)) {
								
								for($ia=0; $ia<count($data_sub_sub); $ia++) {

									$ni++;
									$data_sub_sub[$ia][num] = $ni;

									$data_sub_sub[$ia]['cate_2'] = substr($data_sub_sub[$ia]['num_cate'],0,strlen($data_sub_sub[$ia]['num_cate'])-2)."|";
								}
								

								$data_sub[$i]['SUBMENU_SUB_SUB'] = $data_sub_sub;
								$data_sub[$i]['is_sub'] = true;
							}


							}

							$data[$ii]['SUBMENU_SUB'] = $data_sub;

							$data[$ii]['is_sub'] = true;
						}
					}
				}
					
			}

	$tpl->assign(array(
	'SUBMENU'      => $data,
	'current_menu' => $current_menu,
	'current_menu2' => $current_menu2,
	'mcode__1'        => $mcode,
	'mcode_2'        => substr($mcode,0,$mlen-2),
	'class'        => $class,
	'class_current'=> $class_current,
	'mcode'=> _MCODE,
	));


	$tpl->setLayout('admin');
	$tpl->define("CONTENT", Display::getTemplate("menu/admin/move_tree.htm"));
	
	


	



		 //WebApp::moveBack();
		 


?>