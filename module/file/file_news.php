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

$TABLE_NUM = '';
$ARTICLE_TABLE = 'TAB_BOARD'.$TABLE_NUM;
$CONFIG_TABLE = $ARTICLE_TABLE.'_CONFIG';
$COMMENT_TABLE = $ARTICLE_TABLE.'_COMMENT';

$ARTICLE_PRIMARY_INDEX = 'PK_'.$ARTICLE_TABLE;
$CONFIG_PRIMARY_INDEX = 'PK_'.$CONFIG_TABLE;
$COMMENT_PRIMARY_INDEX = 'PK_'.$COMMENT_TABLE;
$ARTICLE_SEARCH_INDEX = 'IDX_'.$ARTICLE_TABLE.'_SEARCH';
//$ARTICLE_DEPTH_INDEX = 'IDX_'.$ARTICLE_TABLE.'_DEPTH';
$ARTICLE_ALL_INDEX = 'IDX_'.$ARTICLE_TABLE.'_ALL';

$DB = &WebApp::singleton('DB');
if(!$mcode) $mcode = "editor";
$FH = &WebApp::singleton('FileHost','menu',$mcode);
$FH->set_oid($oid);





if (!$serial) {
$sql = "SELECT MAX(NUM_SERIAL) FROM ".TAB_MAIN_BOARD." WHERE NUM_OID=$_OID AND STR_CODE='$code'";
$serial = $DB->sqlFetchOne($sql) + 1;
}

$id = $serial;


		
			$num_file = ($upfiles = trim($_POST['upfiles'])) ? count(explode("\n",$upfiles)) : 0;
			if ($num_file) {
				$FILE_LIST = $FH->upload_process_tmp($_POST['timestamp'],$id);
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

		


//print_r($FILE_LIST);

for($ii=0; $ii<count($FILE_LIST); $ii++) {
?>

<div id="files_<?=$FILE_LIST[$ii][num_serial]?>" style = "display:">



<? 
// 2008-05-11 종태 이미지 파일처리
if($FILE_LIST[$ii][str_ftype] == "gif" ||$FILE_LIST[$ii][str_ftype] == "jpg" ||$FILE_LIST[$ii][str_ftype] == "png" ) {
$size_a[$ii]=GetImageSize($FH->get_real_url($FILE_LIST[$ii]['str_refile']));	
?>

<a href="javascript:copyFileUrlNoId('<?=$FILE_LIST[$ii][num_serial]?>','<?=$FILE_LIST[$ii][str_upfile]?>','center','<?=$size_a[$ii][0]?>','<?=$id?>','<?=$FILE_LIST[$ii][str_url]?>')" >

<? }else{ 
// 2008-05-11 종태 그냥 파일일경우
?>

<a href="javascript:copyFileUrl2('<?=$FILE_LIST[$ii][num_serial]?>','<?=$FILE_LIST[$ii][str_upfile]?>','<?=$FILE_LIST[$ii][str_ftype]?>','<?=$id?>','<?=$FILE_LIST[$ii][str_url]?>')" > 

<? } ?>



<img src="/image/icon/<?=$FILE_LIST[$ii][str_ftype]?>.gif" align="absmiddle" onerror="this.src='/image/icon/unknown.gif';" border="0"> <?=$FILE_LIST[$ii][str_upfile]?></a>

<a href="javascript:del_file('<?=$FILE_LIST[$ii][num_serial]?>','<?=$FILE_LIST[$ii][str_upfile]?>','<?=$id?>');"> <img src="/image/editor/bg_transparent.gif" align="absmiddle"></a> 


<? 
if($FILE_LIST[$ii][str_ftype] == "gif" ||$FILE_LIST[$ii][str_ftype] == "jpg" ||$FILE_LIST[$ii][str_ftype] == "png" ) {

?>

<a href="javascript:copyFileUrlNoId('<?=$FILE_LIST[$ii][num_serial]?>','<?=$FILE_LIST[$ii][str_upfile]?>','center','<?=$size_a[$ii][0]?>','<?=$id?>','<?=$FILE_LIST[$ii][str_url]?>')" style="font-size:11px;color:#C8C8C8">
이미지삽입</a>


<? }else{ 
// 2008-05-11 종태 그냥 파일일경우	
?>


<a href="javascript:copyFileUrl2('<?=$FILE_LIST[$ii][num_serial]?>','<?=$FILE_LIST[$ii][str_upfile]?>','<?=$FILE_LIST[$ii][str_ftype]?>','<?=$id?>','<?=$FILE_LIST[$ii][str_url]?>')" style="font-size:11px;color:#C8C8C8"> 
파일링크 삽입</a>

<? } ?><br>
</div>



<? } 

$max = count($FILE_LIST)-1;
if($FILE_LIST[$max][str_ftype] == "gif" ||$FILE_LIST[$max][str_ftype] == "jpg" ||$FILE_LIST[$max][str_ftype] == "png" ) {

	$size=GetImageSize($FH->get_real_url($FILE_LIST[$max]['str_refile']));
}
?>
|||<?=$FILE_LIST[$max][str_ftype]?>|||<?=$FILE_LIST[$max][str_upfile]?>|||<?=$FILE_LIST[$max][num_serial]?>|||<?=$size[0]?>|||<?=$size[1]?>|||<?=$id?>|||<?=$FILE_LIST[$max][str_url]?>
