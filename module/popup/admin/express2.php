<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: express.php
* 작성일: 2005-03-04
* 작성자: 이범민
* 설  명: 팝업창 표출 설정
*****************************************************************
* 
*/
$ids = $_REQUEST['ids'];

$DB = &WebApp::singleton('DB');
$sql = "UPDATE ".TAB_POPUP." SET CHR_TOP_OPEN='N' WHERE NUM_OID=$_OID AND CHR_OPEN in ('N','Y')";
$DB->query($sql);
$DB->commit();

if($ids) {
	$sql = "UPDATE ".TAB_POPUP." SET CHR_TOP_OPEN='Y' WHERE NUM_OID=$_OID AND NUM_SERIAL IN ($ids)";
	$DB->query($sql);
	$DB->commit();
}

$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
$FTP->delete(_DOC_ROOT."/hosts/".HOST."/files/popup/popup.js");
$FTP->close();

//echo "{'Code':'00','Message':'팝업창 표출 설정이 완료되었습니다.'}";
?>