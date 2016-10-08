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

		$sql = "select num_mcode,str_title from TAB_MENU where num_oid = '$_OID' and str_type like 'board%' order by num_mcode";
		$bbs_row = $DB -> sqlFetchAll($sql);
		for($ii=0 ; $ii<sizeof($bbs_row) ; $ii++){

			
				if(strlen($bbs_row[$ii][num_mcode])%2 == 0){
		 $_lens = 2;
		 
		if(strlen($bbs_row[$ii][num_mcode]) == 6) {

			 $bbs_row[$ii][stitle] = $DB -> sqlFetchOne("select str_title from TAB_MENU where num_oid = $_OID and num_mcode = ".substr($bbs_row[$ii][num_mcode],0,2)." ");
			$bbs_row[$ii][stitle] .= "> ".$DB -> sqlFetchOne("select str_title from TAB_MENU where num_oid = $_OID and num_mcode = ".substr($bbs_row[$ii][num_mcode],0,4)." ");
		
		}

		if(strlen($bbs_row[$ii][num_mcode]) == 4) {

			 $bbs_row[$ii][stitle] = $DB -> sqlFetchOne("select str_title from TAB_MENU where num_oid = $_OID and num_mcode = ".substr($bbs_row[$ii][num_mcode],0,2)." ");
		}
		 
		 }else{
		 $_lens = 3;

 		if(strlen($bbs_row[$ii][num_mcode]) == 7) {

			 $bbs_row[$ii][stitle] = $DB -> sqlFetchOne("select str_title from TAB_MENU where num_oid = $_OID and num_mcode = ".substr($bbs_row[$ii][num_mcode],0,3)." ");
			$bbs_row[$ii][stitle] .= "> ".$DB -> sqlFetchOne("select str_title from TAB_MENU where num_oid = $_OID and num_mcode = ".substr($bbs_row[$ii][num_mcode],0,5)." ");
		
		}

		if(strlen($bbs_row[$ii][num_mcode]) == 5) {

			 $bbs_row[$ii][stitle] = $DB -> sqlFetchOne("select str_title from TAB_MENU where num_oid = $_OID and num_mcode = ".substr($bbs_row[$ii][num_mcode],0,3)." ");
		}
		 }
			



			
		}
		$tpl->assign(array('LIST'=>$bbs_row));

		$tpl->assign(array(
		'bbsList'=>$bbs,
		'total'=>$ii,
		'mcode' => $mcode,));

		$tpl->setLayout('admin');
		$tpl->define("CONTENT", Display::getTemplate("board/copy.htm"));

	break;
	case "del":

		if(strstr($bbs ,"|")) {
			$bbs_array = explode("|",$bbs);
			for($ii=0; $ii<count($bbs_array); $ii++) {
				$sql = "delete from ".TAB_BOARD." WHERE num_oid=$_OID and num_mcode= '".$mcode."' and num_serial = '".$bbs_array[$ii]."'";
				$DB->query($sql);
				$DB->commit();


				$DB->deleteQuery("TAB_FILES"," num_oid = "._OID." and str_sect = 'menu' and str_code = '".$mcode."' and num_main = '".$bbs_array[$ii]."' ");
				$DB->commit();

				$DB->deleteQuery("TAB_BOARD_COMMENT"," num_oid = "._OID." and num_mcode = '".$mcode."' and num_main = '".$bbs_array[$ii]."' ");
				$DB->commit();


				//2011-07-11 종태 검색엔진에 키워드 등록
				$sch_data[str_url] = "/board.view?mcode=".$mcode."&id=".$bbs_array[$ii];
				$DB->deleteQuery("TAB_SCH"," num_oid = "._OID." and str_url = '".$sch_data[str_url]."' ");
				$DB->commit();

			}
		}else{
			$sql = "delete from ".TAB_BOARD." WHERE num_oid=$_OID and num_mcode= '".$mcode."' and num_serial = '".$bbs."'";
			$DB->query($sql);
			$DB->commit();

			//2011-07-11 종태 검색엔진에 키워드 등록
			$sch_data[str_url] = "/board.view?mcode=".$mcode."&id=".$bbs;
			$DB->deleteQuery("TAB_SCH"," num_oid = "._OID." and str_url = '".$sch_data[str_url]."' ");
			$DB->commit();

			$DB->deleteQuery("TAB_FILES"," num_oid = "._OID." and str_sect = 'menu' and str_code = '".$mcode."' and num_main = '".$bbs."' ");
			$DB->commit();

			$DB->deleteQuery("TAB_BOARD_COMMENT"," num_oid = "._OID." and num_mcode = '".$mcode."' and num_main = '".$bbs."' ");
			$DB->commit();

		}
		deleteCacheFiles($mcode);
		echo "<script>
		parent.location.reload();
		parent.closew2()
		</script>";



	

	break;
	case "move":
		$_mcode = $mmcode;
		if(strstr($bbs ,"|")) {
			$bbs_array = explode("|",$bbs);
			$sql = "select max(num_serial) +1 from TAB_BOARD where num_oid = '$_OID' and num_mcode = '$_mcode' ";
			$max_num = $DB -> sqlFetchOne($sql);
			if($max_num) $max_num + 1; else $max_num ="1";
			
			sort($bbs_array);
			for($ii=0; $ii<count($bbs_array); $ii++) {
				$sql = "UPDATE ".TAB_BOARD." set num_mcode = '$_mcode' , num_serial = '".$max_num."' , num_group = '".$max_num."' , str_category = '$cate' WHERE num_oid=$_OID and num_mcode= '".$mcode."' and num_serial = '".$bbs_array[$ii]."'";
				$DB->query($sql);
				$DB->commit();

				$sql = "UPDATE ".TAB_FILES." set str_code = '$_mcode' ,  num_main = '".$max_num."'    WHERE num_oid=$_OID and str_code= '".$mcode."' and num_main = '".$bbs_array[$ii]."' and str_sect = 'menu'";
				$DB->query($sql);
				$DB->commit();
				

				//2011-07-11 종태 검색엔진에 키워드 등록
				$str_urls = "/board.view?mcode=".$mcode."&id=".$bbs_array[$ii];
				$sch_data[str_url] ="/board.view?mcode=".$_mcode."&id=".$max_num;
				$DB->updateQuery("TAB_SCH",$sch_data, " num_oid = '"._OID."'  and str_url = '".$str_urls."' ");
				$DB->commit();

				$max_num++;

				

			}

		}else{
			$sql = "select max(num_serial) + 1 from TAB_BOARD where num_oid = '$_OID' and num_mcode = '$_mcode' ";

			$max_num = $DB -> sqlFetchOne($sql);
			if($max_num) $max_num + 1; else $max_num ="1";

			$sql = "UPDATE ".TAB_BOARD." set num_mcode = '$_mcode' , num_serial = '".$max_num."' , num_group = '".$max_num."' ,  str_category = '$cate' WHERE num_oid=$_OID and num_mcode= '".$mcode."' and num_serial = '".$bbs."'";
			 $DB->query($sql);
			 $DB->commit();

			$sql = "UPDATE ".TAB_FILES." set str_code = '$_mcode' ,  num_main = '".$max_num."'    WHERE num_oid=$_OID and str_code= '".$mcode."' and num_main = '".$bbs."' and str_sect = 'menu'";
			 $DB->query($sql);
			 $DB->commit();

			 //2011-07-11 종태 검색엔진에 키워드 등록
			$str_urls = "/board.view?mcode=".$mcode."&id=".$bbs;
			$sch_data[str_url] ="/board.view?mcode=".$_mcode."&id=".$max_num;
			$DB->updateQuery("TAB_SCH",$sch_data, " num_oid = '"._OID."'  and str_url = '".$str_urls."' ");
			$DB->commit();
		}
		
		
		deleteCacheFiles($mcode);

		echo "<script>
		parent.location.reload();
		parent.closew2()
		</script>";
	break;
}





		function deleteCacheFiles($mcode) {
			$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));

				  $dellist=array();
				  $dellist[]="inc.main.out_bbs1.htm";
				  $dellist[]="inc.main.out_bbs2.htm";
				  $dellist[]="inc.main.out_bbs3.htm";
				  $dellist[]="inc.main.out_bbs4.htm";
				  $dellist[]="inc.main.out_bbs5.htm";
				

				for($ii=0; $ii<count($dellist); $ii++) {
				$FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/'.$dellist[$ii]);
				}

		}

?>