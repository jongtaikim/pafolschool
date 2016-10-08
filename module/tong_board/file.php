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
$FH = &WebApp::singleton('FileHost','menu',$mcode);
$FH->set_oid($oid);





if (!$serial) {
// {{{ 업로드한 파일 처리
$serial = $DB->sqlFetchOne("
			SELECT
				/*+ INDEX_DESC ($ARTICLE_TABLE $ARTICLE_SEARCH_INDEX) */
					max(num_serial) + 1
			FROM
				$ARTICLE_TABLE
			WHERE
				 num_oid = '$_OID' and  num_mcode=$mcode 
		");

}

$id = $serial;

			$num_file = ($upfiles = trim($_POST['upfiles'])) ? count(explode("\n",$upfiles)) : 0;
			if ($num_file) {
				$FH->upload_process($_POST['timestamp'],$id);
				$FH->rm_tmp_dir($_POST['timestamp']);
			}
			
			if($FH->thumb_target) $get_thumb_filename = $FH->thumb_target;
			$FH->close();
			// }}}
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

			$FH->rm_tmp_files($_POST['timestamp']);
			$FH->close();

		$FILE_LIST = $FH->get_files_info($id);
		$total_size = array_pop($FILE_LIST);

//print_r($FILE_LIST);

for($ii=0; $ii<count($FILE_LIST); $ii++) {
?>

<div id="files_<?=$FILE_LIST[$ii][num_serial]?>" style = "display:">



<? 
if($FILE_LIST[$ii][str_ftype] == "gif" ||$FILE_LIST[$ii][str_ftype] == "jpg" ||$FILE_LIST[$ii][str_ftype] == "png" ) {?>

<a href="javascript:copyFileUrl('<?=$FILE_LIST[$ii][num_serial]?>','<?=$FILE_LIST[$ii][str_upfile]?>')" >

<? }else{ ?>

<a href="javascript:copyFileUrl2('<?=$FILE_LIST[$ii][num_serial]?>','<?=$FILE_LIST[$ii][str_upfile]?>','<?=$FILE_LIST[$ii][str_ftype]?>')" > 

<? } ?>



<img src="/image/icon/<?=$FILE_LIST[$ii][str_ftype]?>.gif" align="absmiddle" onerror="this.src='/image/icon/unknown.gif';" border="0"> <?=$FILE_LIST[$ii][str_upfile]?></a><a href="javascript:del_file(<?=$FILE_LIST[$ii][num_serial]?>);"> <img src="/image/editor/bg_transparent.gif" align="absmiddle"></a> 


<? 
if($FILE_LIST[$ii][str_ftype] == "gif" ||$FILE_LIST[$ii][str_ftype] == "jpg" ||$FILE_LIST[$ii][str_ftype] == "png" ) {

?>


<a href="javascript:copyFileUrl('<?=$FILE_LIST[$ii][num_serial]?>','<?=$FILE_LIST[$ii][str_upfile]?>')" style="font-size:11px;color:#C8C8C8">이미지삽입</a> | <font style = "font-size:11px;color:#FF0033">겔러리등록됨</font>


<? }else{ ?>


<a href="javascript:copyFileUrl2('<?=$FILE_LIST[$ii][num_serial]?>','<?=$FILE_LIST[$ii][str_upfile]?>','<?=$FILE_LIST[$ii][str_ftype]?>')" style="font-size:11px;color:#C8C8C8"> 
파일링크 삽입</a>

<? } ?><br>
</div>



<? } 

$max = count($FILE_LIST)-1;
if($FILE_LIST[$max][str_ftype] == "gif" ||$FILE_LIST[$max][str_ftype] == "jpg" ||$FILE_LIST[$max][str_ftype] == "png" ) {

	$size=GetImageSize($FH->get_real_url($FILE_LIST[$max]['str_refile']));
}
?>
|||<?=$FILE_LIST[$max][str_ftype]?>|||<?=$FILE_LIST[$max][str_upfile]?>|||<?=$FILE_LIST[$max][num_serial]?>|||<?=$size[0]?>|||<?=$size[1]?>
