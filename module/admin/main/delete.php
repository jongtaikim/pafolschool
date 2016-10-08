<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/news/admin/delete.php
* 작성일: 2005-03-23
* 작성자: 이범민
* 설  명: 
*****************************************************************
* 
*/
$_OID2 = "1";
if(!$ids = $_REQUEST['ids']) WebApp::raiseError('잘못된 요청입니다.');
$ids = explode(',',$ids);
$DB = &WebApp::singleton('DB');
$FH = &WebApp::singleton('FileHost','main','news.'.$code);
foreach($ids as $id) {
	if(!$id) continue;
	$sql = "SELECT STR_TEXT1,STR_TEXT2,STR_TEXT3,STR_THUMB FROM ".TAB_MAIN_BOARD." WHERE NUM_OID=$_OID2 AND STR_CODE='$code' AND NUM_SERIAL=$id";
	$data = $DB->sqlFetch($sql);
	
	$sql = "DELETE FROM ".TAB_MAIN_BOARD." WHERE NUM_OID=$_OID2 AND STR_CODE='$code' AND NUM_SERIAL=$id";
	if($DB->query($sql)) {
		$DB->commit();
		$FH->delete_as_html($data['str_text1'].$data['str_text2'].$data['str_text3']);
		$FH->delete_as_main($id);
		if($data['str_thumb']) $FH->del_thumb($data['str_thumb'],$conf['thumb_width']);
	}
}
$FH->close();

// 캐쉬삭제
$FTP = &WebApp::singleton("FtpClient",WebApp::getConf("account"));
$FTP->delete(_DOC_ROOT.'/'.$cache_file);
$FTP->close();

WebApp::redirect($URL->setVar(array('act'=>'.list','ids'=>'')),'삭제되었습니다.');
?>