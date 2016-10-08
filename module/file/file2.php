<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: write.php
* 작성일: 2008-05-10
* 작성자: 김종태
* 설  명: ajax용 파일 갱신
*****************************************************************
* 
*/


$DB = &WebApp::singleton('DB');

switch ($modet) {

case "board_90000":


$FH = &WebApp::singleton('FileHost','menu',$mcode);	

	
	if (!$serial) {
// {{{ 업로드한 파일 처리
$sql = "
			SELECT
			
					max(num_serial) + 1
			FROM
				TAB_BOARD
			WHERE
				 num_oid = '$_OID' 
		";
$serial = $DB->sqlFetchOne($sql);

}


	 break;
	
	case "board":


$FH = &WebApp::singleton('FileHost','menu',$mcode);	

	
	if (!$serial) {
// {{{ 업로드한 파일 처리
$sql = "
			SELECT
			
					max(num_serial) + 1
			FROM
				TAB_BOARD
			WHERE
				 num_oid = '$_OID' and  num_mcode=$mcode 
		";
$serial = $DB->sqlFetchOne($sql);

}

	
	 break;
	case "news":


$FH = &WebApp::singleton('FileHost','main','news.'.$codet);

if (!$serial) {
$sql = "SELECT MAX(NUM_SERIAL) FROM ".TAB_MAIN_BOARD." WHERE NUM_OID=$_OID AND STR_CODE='$codet'";
$serial = $DB->sqlFetchOne($sql) + 1;
}
	
	break;




case "class":

$FH = &WebApp::singleton('FileHost','class',$codet.'.'.$mcode);

if (!$serial) {


$sql= "
			SELECT
				
				max(num_serial) + 1
			FROM
				TAB_CLASS_BOARD
			WHERE
				num_oid='$_OID' AND num_fcode='$codet' AND num_mcode='$mcode' 
		";

		$serial = $DB->sqlFetchOne($sql);

}
	
	break;


case "party":


$FH = &WebApp::singleton('FileHost','party',$codet.'.'.$mcode);
$sql = "
			SELECT
			/*+ INDEX_DESC (TAB_PARTY_BOARD PK_TAB_PARTY_BOARD_PK) */
				max(num_serial)+1
			FROM
				$ARTICLE_TABLE
			WHERE
				num_oid=$_OID AND num_pcode=$codet AND num_mcode=$mcode
		";


if (!$serial) {
		$serial = $DB->sqlFetchOne($sql);

}
	
	break;
	}




$FH->set_oid($oid);


if(!$serial) $serial = 1;
$id = $serial;


			$num_file = ($upfiles = trim($_POST['upfiles'])) ? count(explode("\n",$upfiles)) : 0;
			
			if ($num_file) {
				$FILE_LIST_tmp = $FH->upload_process($_POST['timestamp'],$id);
				
				$FH->rm_tmp_dir($_POST['timestamp']);
			}
			
			if($FH->thumb_target) $get_thumb_filename = $FH->thumb_target;
			//$FH->close();
			// }}}
			

			$_SESSION['get_thumb_filename'] = $get_thumb_filename;
/*			
			$sql="
				UPDATE
					$ARTICLE_TABLE
				SET
					num_file=$origin_num_file + $num_file,
					str_thumb='$get_thumb_filename'
				WHERE
					$que num_mcode=$mcode AND num_serial=$id
			";
			if ($DB->query($sql)) $DB->commit();
*/
			$FH->rm_tmp_files($_POST['timestamp']);
			$FH->close();

		

		
	
		$FILE_LIST = $FH->get_files_info($id);
		$total_size = array_pop($files);
		
		



for($ii=0; $ii<count($FILE_LIST)-1; $ii++) {
?>

<div id="files_<?=$FILE_LIST[$ii][num_serial]?>" style = "display:">



<? // 2008-05-11 종태 이미지 파일처리
if($FILE_LIST[$ii][str_ftype] == "gif" ||$FILE_LIST[$ii][str_ftype] == "jpg" ||$FILE_LIST[$ii][str_ftype] == "png" ) {
$size_a[$ii]=GetImageSize($FH->get_real_url($FILE_LIST[$ii]['str_refile']));	
?>

<a href="javascript:copyFileUrlNoId('<?=$FILE_LIST[$ii][num_serial]?>','<?=$FILE_LIST[$ii][str_upfile]?>','center','<?=$size_a[$ii][0]?>','<?=$id?>','<?=$FILE_LIST[$ii][real_url]?>')" >


<img src="/image/icon/<?=$FILE_LIST[$ii][str_ftype]?>.gif" align="absmiddle" onerror="this.src='/image/icon/unknown.gif';" border="0">

<?=$FILE_LIST[$ii][str_upfile]?></a>

<a href="javascript:del_file('<?=$FILE_LIST[$ii][num_serial]?>','<?=$FILE_LIST[$ii][str_upfile]?>','<?=$id?>');"> <img src="/image/editor/bg_transparent.gif" align="absmiddle"></a> 
















<? }elseif($FILE_LIST[$ii][str_ftype] == "wmv" ||$FILE_LIST[$ii][str_ftype] == "avi" ||$FILE_LIST[$ii][str_ftype] == "mpeg") { ?>
	
<a href="javascript:copyFileUrlNoIdMovie('<?=$FILE_LIST[$ii][num_serial]?>','<?=$FILE_LIST[$ii][str_upfile]?>','<?=$FILE_LIST[$ii][real_url]?>')" > 

<img src="/image/icon/<?=$FILE_LIST[$ii][str_ftype]?>.gif" align="absmiddle" onerror="this.src='/image/icon/unknown.gif';" border="0">
<?=$FILE_LIST[$ii][str_upfile]?></a>
<a href="javascript:del_file('<?=$FILE_LIST[$ii][num_serial]?>','<?=$FILE_LIST[$ii][str_upfile]?>','<?=$id?>');"> <img src="/image/editor/bg_transparent.gif" align="absmiddle"></a> 












<? }elseif($FILE_LIST[$ii][str_ftype] == "wma" ||$FILE_LIST[$ii][str_ftype] == "mp3" ) { ?>
	
<a href="javascript:copyFileUrlNoIdMp3('<?=$FILE_LIST[$ii][num_serial]?>','<?=$FILE_LIST[$ii][str_upfile]?>','<?=$FILE_LIST[$ii][real_url]?>')" > 

<img src="/image/icon/<?=$FILE_LIST[$ii][str_ftype]?>.gif" align="absmiddle" onerror="this.src='/image/icon/unknown.gif';" border="0">
<?=$FILE_LIST[$ii][str_upfile]?></a>
<a href="javascript:del_file('<?=$FILE_LIST[$ii][num_serial]?>','<?=$FILE_LIST[$ii][str_upfile]?>','<?=$id?>');"> <img src="/image/editor/bg_transparent.gif" align="absmiddle"></a> 









<? }else{ // 2008-05-11 종태 그냥 파일일경우 ?>

<a href="javascript:copyFileUrl2('<?=$FILE_LIST[$ii][num_serial]?>','<?=$FILE_LIST[$ii][str_upfile]?>','<?=$FILE_LIST[$ii][str_ftype]?>','<?=$id?>','<?=$FILE_LIST[$ii][real_url]?>')" > 


<img src="/image/icon/<?=$FILE_LIST[$ii][str_ftype]?>.gif" align="absmiddle" onerror="this.src='/image/icon/unknown.gif';" border="0"> 
<?=$FILE_LIST[$ii][str_upfile]?></a>

<a href="javascript:del_file('<?=$FILE_LIST[$ii][num_serial]?>','<?=$FILE_LIST[$ii][str_upfile]?>','<?=$id?>');"> <img src="/image/editor/bg_transparent.gif" align="absmiddle"></a> 


<? } ?>



<br>
</div>



<? }  



echo "%%%%%%%%%%";



for($ii=0; $ii<count($FILE_LIST_tmp); $ii++) {
	



if($FILE_LIST_tmp[$ii][str_ftype] == "gif" ||$FILE_LIST_tmp[$ii][str_ftype] == "jpg" ||$FILE_LIST_tmp[$ii][str_ftype] == "png" ) {
$size=GetImageSize($FH->get_real_url($FILE_LIST_tmp[$ii]['str_refile']));
}

echo $FILE_LIST_tmp[$ii][str_ftype]."|||".$FILE_LIST_tmp[$ii][str_upfile]."|||".$FILE_LIST_tmp[$ii][num_serial]."|||".$size[0]."|||".$size[1]."|||".$id."|||".$FILE_LIST_tmp[$ii][str_url]."&&&";

}


?>
