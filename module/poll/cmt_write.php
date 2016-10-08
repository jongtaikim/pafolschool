<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/poll/cmt_write.php
* 작성일: 2005-03-25
* 작성자: 이범민
* 설  명: 설문조사 나도한마디 작성
*****************************************************************
* TODO : 권한체크
*/

switch($REQUEST_METHOD) {
	case "GET":
		WebApp::raiseError('잘못된 요청입니다.');
	break;
	case "POST":
		if(!$main = $_REQUEST['main']) WebApp::raiseError('잘못된 요청입니다.');
		$str_name = trim(strip_tags($_POST['str_name']));
		$str_id = $_SESSION['USERID'];
		$str_comment = trim($_POST['str_comment']);
		$str_pass = $_POST['str_pass'];

		$DB = &WebApp::singleton('DB');
		$sql = "SELECT MAX(NUM_SERIAL) FROM ".TAB_POLL_COMMENT." WHERE NUM_OID=$_OID AND NUM_MAIN=$main";
		$id = $DB->sqlFetchOne($sql) + 1;
		$str_ip = getenv("REMOTE_ADDR");

		$sql = "INSERT INTO ".TAB_POLL_COMMENT." (
					NUM_OID,NUM_MAIN,NUM_SERIAL,STR_COMMENT,STR_ID,STR_NAME,STR_PASS,DT_DATE,STR_IP
				) VALUES (
					$_OID,$main,$id,'$str_comment','$str_id','$str_name','$str_pass',SYSDATE,'$str_ip'
				)";
		if($DB->query($sql)) {
			$DB->commit();
			WebApp::redirect($URL->setVar(array('act'=>'.view','sect'=>$sect,'id'=>$main)));
		} else {
			WebApp::raiseError('등록 실패');
		}
	break;
}
?>