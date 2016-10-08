<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/party/council/admin/__del.php
* 작성일: 2006-05-12
* 작성자: 이범민
* 설  명: 
*****************************************************************
* 
*/
// 첨부파일 지우고 첨부파일 DB 초기화하기
$FH = &WebApp::singleton('FileHost','party',$pcode.'.'.$mcode);
$FH->delete_as_code('party',$pcode.'.'.$mcode);
$FH->close();
unset($FH);

// 게시물 내용 지우기
$DB->query("DELETE FROM ".TAB_PARTY_COUNCIL." WHERE num_oid=$_OID AND num_pcode=$pcode AND num_mcode=$mcode");
$DB->commit();

// 게시판 설정 지우기
$DB->query("DELETE FROM ".TAB_PARTY_COUNCIL_CONFIG." WHERE num_oid=$_OID AND num_pcode=$pcode AND num_mcode=$mcode");
$DB->commit();

include 'module/party/council/admin/__init__.php';
updateConf($pcode,$mcode,$party_conf_file);
?>