<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/poll/cmt_delete.php
* 작성일: 2005-03-25
* 작성자: 이범민
* 설  명: 
*****************************************************************
* 
*/
$main = $_REQUEST['main'];
$id = $_REQUEST['id'];
if(!$main || !$id) WebApp::moveBack('잘못된 요청입니다.');

switch($REQUEST_METHOD) {
	case "GET":
		$tpl->setLayout($layout);
		$tpl->define('CONTENT','html/poll/skin/'.$skin.'/cmt_delete.htm');
		$tpl->assign(array(
			'sect'=>$sect,
			'main'=>$main,
			'id'=>$id
		));

		//$PERM = &WebApp::singleton('Permission','main','poll');
		//if($PERM->check('x')) {
			$DB = &WebApp::singleton('DB');
			$sql = "SELECT STR_PASS FROM ".TAB_POLL_COMMENT." WHERE NUM_OID=$_OID AND NUM_MAIN=$main AND NUM_SERIAL=$id";
//			echo $sql ;
			if(!$passwd = $DB->sqlFetchOne($sql)) WebApp::raiseError('해당 게시물이 존재하지 않습니다.');
			$tpl->assign('passwd',$passwd);
		//}
	break;
	case "POST":
		$passwd = $_POST['passwd'];
		if($passwd != '') {
			$DB = &WebApp::singleton('DB');
			$sql = "SELECT STR_PASS FROM ".TAB_POLL_COMMENT." WHERE NUM_OID=$_OID AND NUM_MAIN=$main AND NUM_SERIAL=$id";
			$cmp_passwd = $DB->sqlFetchOne($sql);
			if($passwd != $cmp_passwd) WebApp::moveBack('비밀번호가 일치하지 않습니다.');

			$sql = "DELETE FROM ".TAB_POLL_COMMENT." WHERE NUM_OID=$_OID AND NUM_MAIN=$main AND NUM_SERIAL=$id";
			echo $sql ;
			if(!$DB->query($sql)) {
				WebApp::raiseError('해당 게시물이 존재하지 않습니다.');
			} else {
				$DB->commit();
				WebApp::moveBack('삭제되었습니다.');
				
			}
		} else {
			WebApp::raiseError('비밀번호를 입력하여 주십시오.');
		}
	break;
}
?>