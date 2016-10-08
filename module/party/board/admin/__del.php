<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/party/board/admin/__del.php
* 작성일: 2006-05-16
* 작성자: 이범민
* 설  명: 
*****************************************************************
* 
*/
// 첨부파일 지우고 첨부파일 DB 초기화하기
include 'module/party/board/table_define.php';
$FH = &WebApp::singleton('FileHost','party',$pcode.'.'.$mcode);
$FH->delete_as_code($pcode.'.'.$mcode);

// 썸네일 삭제
$sql = "SELECT STR_THUMB FROM $ARTICLE_TABLE WHERE num_oid=$_OID AND num_pcode=$pcode AND num_mcode=$mcode AND str_thumb IS NOT NULL";
if($thumb_data = $DB->sqlFetchAll($sql)) {
	foreach($thumb_data as $row) $del_thumbs[] = $row['str_thumb'];
	$FH->del_thumb($del_thumbs);
}
$FH->close();

// 게시물 내용 지우기
$DB->query("DELETE FROM TAB_PARTY_BOARD WHERE num_oid=$_OID AND num_pcode=$pcode AND num_mcode=$mcode");
$DB->commit();

// 게시물 Comment 삭제
$DB->query("DELETE FROM TAB_PARTY_BOARD_COMMENT WHERE num_oid=$_OID AND num_pcode=$pcode AND num_mcode=$mcode");
$DB->commit();

// 게시판 설정 지우기
$DB->query("DELETE FROM TAB_PARTY_BOARD_CONFIG WHERE num_oid=$_OID AND num_pcode=$pcode AND num_mcode=$mcode");
$DB->commit();

include 'module/party/board/admin/__init__.php';
updateConf($pcode,$mcode,$party_conf_file);
?>