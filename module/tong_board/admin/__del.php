<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/board/admin/del.php
* 작성일: 2005-03-28
* 작성자: 이범민
* 설  명: 
*****************************************************************
* 
*/
// 첨부파일 지우고 첨부파일 DB 초기화하기
require_once 'module/board/table_define.php';
$FH = &WebApp::singleton('FileHost','menu',$mcode);
$FH->delete_as_code('menu',$mcode);

// 썸네일 삭제
$sql = "SELECT STR_THUMB FROM $ARTICLE_TABLE WHERE NUM_OID=$_OID AND NUM_MCODE=$mcode AND STR_THUMB IS NOT NULL";
if($thumb_data = $DB->sqlFetchAll($sql)) {
	foreach($thumb_data as $row) $del_thumbs[] = $row['str_thumb'];
	$FH->del_thumb($del_thumbs);
}
$FH->close();

// 게시물 내용 지우기
$DB->query("DELETE FROM $ARTICLE_TABLE WHERE num_oid=$_OID AND num_mcode=$mcode");
$DB->commit();

// 게시물 Comment 삭제
$DB->query("DELETE FROM $COMMENT_TABLE WHERE num_oid=$_OID and num_mcode=$mcode");
$DB->commit();

$listtype = $DB->sqlFetchOne("SELECT chr_listtype FROM $CONFIG_TABLE WHERE num_oid=$_OID AND num_mcode=$mcode");

// 게시판 설정 지우기
$DB->query("DELETE FROM $CONFIG_TABLE WHERE num_oid=$_OID AND num_mcode=$mcode");
$DB->commit();

// 설정파일, 최근게시물 삭제
$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
$FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/conf/board/'.$mcode.'.conf.php');
$FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/inc.main.latestboard.'.$listtype.'.htm');





$name = "bbs_".$mcode;

$sql = "DELETE FROM ".TAB_ATTACH_CONFIG." WHERE num_oid=$_OID AND str_name='$name'";
$DB->query($sql);
$DB->commit();

$sql = "DELETE FROM ".TAB_ATTACH_PART." WHERE num_oid=$_OID AND str_name='$name'";
$DB->query($sql);
$DB->commit();


$FTP = WebApp::singleton('FtpClient',WebApp::getConf('account'));
//$FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/'.$attach_file[$ii]);

$attach_conf_file = 'hosts/'.HOST.'/conf/'._CSS.'.attach.conf.php';
$INI = &WebApp::singleton('IniFile',$attach_conf_file);
$INI->delSection($name);
$FTP->put_string($INI->_combine(),_DOC_ROOT.'/'.$attach_conf_file);

?>