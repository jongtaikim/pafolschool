<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: delete.php
* 작성일: 2005-07-21
* 작성자: 이범민
* 설  명: 설문삭제
* [수정] 2007-05-23 (주)아이노크 김미희
*****************************************************************
* 
*/


if(!is_array($_REQUEST['ids'])) $_REQUEST['ids']=$_REQUEST['id'];

if(!$ids = $_REQUEST['ids'] || !is_array($ids)) WebApp::raiseError('잘못된 요청입니다.');

// 2007-05-23 (주)아이노크 김미희
$ids = $_REQUEST['ids'];

$DB = &WebApp::singleton('DB');
$sqls = array(
"DELETE FROM ".TAB_POLL_CONTENTS." WHERE NUM_OID=$_OID AND NUM_MAIN=",
"DELETE FROM ".TAB_POLL_COMMENT." WHERE NUM_OID=$_OID AND NUM_MAIN=",
"DELETE FROM ".TAB_POLL_IP." WHERE NUM_OID=$_OID AND NUM_MAIN=",
"DELETE FROM ".TAB_POLL_USER." WHERE NUM_OID=$_OID AND NUM_MAIN=",
"DELETE FROM ".TAB_POLL_MAIN." WHERE NUM_OID=$_OID AND NUM_SERIAL="
);

// 2007-05-23 (주)아이노크 김미희
if(!is_array($ids)) $ids=array($ids);
foreach($ids as $id) {
	foreach($sqls as $sql) {
		$DB->query($sql.$id);
    $DB->commit();
	}
}

// 캐쉬 삭제
$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
$FTP->delete(_DOC_ROOT.'/'.$cache_file);
$FTP->close();

WebApp::redirect($URL->setVar(array('act'=>'.list','id'=>'')));
?>