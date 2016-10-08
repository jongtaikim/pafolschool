
<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-09-01
* 작성자: 김종태
* 설  명: 게시물 관리
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');


switch ($mode) {
	default:

		for($ii=0; $ii<count($ids); $ii++) {
			$bbs .= $ids[$ii]."|";
		}

		$bbs = substr($bbs,0,strlen($bbs)-1);

		$sql = "select num_mcode,str_title from TAB_PARTY_MENU where num_oid = '$_OID' and num_pcode = ".$pcode." and str_type like 'board%' order by num_mcode";
		$bbs_row = $DB -> sqlFetchAll($sql);
		for($ii=0 ; $ii<sizeof($bbs_row) ; $ii++){

			
				if(strlen($bbs_row[$ii][num_mcode])%2 == 0){
		 $_lens = 2;
		 
		if(strlen($bbs_row[$ii][num_mcode]) == 6) {

			 $bbs_row[$ii][stitle] = $DB -> sqlFetchOne("select str_title from TAB_PARTY_MENU where num_oid = '$_OID' and num_pcode = ".$pcode." and num_mcode = ".substr($bbs_row[$ii][num_mcode],0,2)." ");
			$bbs_row[$ii][stitle] .= "> ".$DB -> sqlFetchOne("select str_title from TAB_PARTY_MENU where num_oid = '$_OID' and num_pcode = ".$pcode." and num_mcode = ".substr($bbs_row[$ii][num_mcode],0,4)." ");
		
		}

		if(strlen($bbs_row[$ii][num_mcode]) == 4) {

			 $bbs_row[$ii][stitle] = $DB -> sqlFetchOne("select str_title from TAB_PARTY_MENU where num_oid = '$_OID' and num_pcode = ".$pcode." and num_mcode = ".substr($bbs_row[$ii][num_mcode],0,2)." ");
		}
		 
		 }else{
		 $_lens = 3;

 		if(strlen($bbs_row[$ii][num_mcode]) == 7) {

			 $bbs_row[$ii][stitle] = $DB -> sqlFetchOne("select str_title from TAB_PARTY_MENU where num_oid = '$_OID' and num_pcode = ".$pcode." and num_mcode = ".substr($bbs_row[$ii][num_mcode],0,3)." ");
			$bbs_row[$ii][stitle] .= "> ".$DB -> sqlFetchOne("select str_title from TAB_PARTY_MENU where num_oid = '$_OID' and num_pcode = ".$pcode." and num_mcode = ".substr($bbs_row[$ii][num_mcode],0,5)." ");
		
		}

		if(strlen($bbs_row[$ii][num_mcode]) == 5) {

			 $bbs_row[$ii][stitle] = $DB -> sqlFetchOne("select str_title from TAB_PARTY_MENU where num_oid = '$_OID' and num_pcode = ".$pcode." and num_mcode = ".substr($bbs_row[$ii][num_mcode],0,3)." ");
		}
		 }
			



			
		}
		$tpl->assign(array('LIST'=>$bbs_row));

		$tpl->assign(array(
		'bbsList'=>$bbs,
		'total'=>$ii,
		'mcode' => $mcode,
		'pcode' => $pcode,
		 
		));

		$tpl->setLayout('admin');
		$tpl->define("CONTENT", Display::getTemplate("party/board/copy.htm"));

	break;
	case "del":
	
		if(strstr($bbs ,"|")) {
			$bbs_array = explode("|",$bbs);
			for($ii=0; $ii<count($bbs_array); $ii++) {
				$sql = "delete from ".TAB_PARTY_BOARD." WHERE num_oid=$_OID and num_pcode = ".$pcode." and num_mcode= '".$mcode."' and num_serial = '".$bbs_array[$ii]."'";
				$DB->query($sql);
				$DB->commit();
			}
		}else{
			$sql = "delete from ".TAB_PARTY_BOARD." WHERE num_oid=$_OID and num_pcode = ".$pcode." and num_mcode= '".$mcode."' and num_serial = '".$bbs."'";
			$DB->query($sql);
			$DB->commit();
		}
		
		echo "<script>
		parent.location.reload();
		parent.closew2()
		</script>";



	

	break;
	case "move":
		$_mcode = $pcode.'.'.$mmcode;
		$__mcode = $mmcode;
		$cate = "일반";

		if(strstr($bbs ,"|")) {
			$bbs_array = explode("|",$bbs);
			$sql = "select max(num_serial) +1 from TAB_PARTY_BOARD where num_oid = '$_OID' and num_pcode = ".$pcode." and num_mcode = '$__mcode' ";
			$max_num = $DB -> sqlFetchOne($sql);
			if($max_num) $max_num + 1; else $max_num ="1";
			
			sort($bbs_array);
			for($ii=0; $ii<count($bbs_array); $ii++) {
				$sql = "UPDATE ".TAB_PARTY_BOARD." set num_mcode = '$__mcode' , num_serial = '".$max_num."' , num_group = '".$max_num."' , str_category = '$cate' WHERE num_oid=$_OID and num_pcode = ".$pcode." and num_mcode= '".$mcode."' and num_serial = '".$bbs_array[$ii]."'";
				$DB->query($sql);
				$DB->commit();

				$sql = "UPDATE ".TAB_FILES." set str_code = '$__mcode' ,  num_main = '".$max_num."'    WHERE num_oid=$_OID and str_code= '".$mcode."' and num_main = '".$bbs_array[$ii]."' and str_sect = 'party'";
				$DB->query($sql);
				$DB->commit();

				$max_num++;
			}

		}else{
			$sql = "select max(num_serial) + 1 from TAB_PARTY_BOARD where num_oid = '$_OID' and num_pcode = ".$pcode." and num_mcode = '$__mcode' ";
		
			$max_num = $DB -> sqlFetchOne($sql);
			if($max_num) $max_num + 1; else $max_num ="1";

			$sql = "UPDATE ".TAB_PARTY_BOARD." set num_mcode = '$__mcode' , num_serial = '".$max_num."' , num_group = '".$max_num."' ,  str_category = '$cate' WHERE num_oid=$_OID and num_mcode= '".$mcode."' and num_serial = '".$bbs."'";
		
			 $DB->query($sql);
			 $DB->commit();

			$sql = "UPDATE ".TAB_FILES." set str_code = '$_mcode' ,  num_main = '".$max_num."'    WHERE num_oid=$_OID and str_code= '".$mcode."' and num_main = '".$bbs."' and str_sect = 'party'";
			 $DB->query($sql);
			 $DB->commit();
		}
		
		
		

		echo "<script>
		parent.location.reload();
		parent.closew2()
		</script>";
	break;
}





		

?>