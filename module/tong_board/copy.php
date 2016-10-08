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

		$sql = "select num_mcode,str_title from TAB_MENU where num_oid = '$_OID' and str_type in ('tong_board#B','board#B')";
		$row = $DB -> sqlFetchAll($sql);
		for($a=0 ; $a<sizeof($row) ; $a++){
			//if((strlen($row[$a][num_mcode])%3 == 0) && (substr($row[$a][num_mcode],0,1) == 2)) continue;
			//if((strlen($row[$a][num_mcode])%3 == 0) && (substr($row[$a][num_mcode],0,1) == 3)) continue;
			$row2[] = $row[$a];
		}
		$tpl->assign(array('LIST'=>$row2));

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
			}
		}else{
			$sql = "delete from ".TAB_BOARD." WHERE num_oid=$_OID and num_mcode= '".$mcode."' and num_serial = '".$bbs."'";
			$DB->query($sql);
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