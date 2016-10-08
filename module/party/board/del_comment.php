<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/party/board/del_comment.php
* 작성일: 2006-05-16
* 작성자: 이범민
* 설  명: 
*****************************************************************
* 
*/

$act = $_REQUEST['act'];
$id = $_REQUEST['id'];
$pass = $_REQUEST['pass'];
$main = $_REQUEST['main'];
$DB = &WebApp::singleton('DB');

$data = $DB->sqlFetch("SELECT str_user, str_pass FROM $COMMENT_TABLE WHERE num_oid=$_OID AND num_pcode=$pcode AND num_mcode=$mcode AND num_main=$main AND num_serial=$id");

if ($id === false) WebApp::moveBack('해당 글이 존재하지 않습니다');
if ($pass || ($_SESSION[USERID] == $data[str_user]) || $env['admin']) {

	if ($pass && ($pass != $data['str_pass'])) WebApp::moveBack("패스워드가 일치하지 않습니다");

	$sql = "DELETE FROM $COMMENT_TABLE WHERE num_oid=$_OID AND num_pcode=$pcode AND num_mcode=$mcode AND num_main=$main AND num_serial=$id";

	if ($DB->query($sql)) {
		$DB->commit();
		$DB->query("
			UPDATE $ARTICLE_TABLE SET
				num_comment=(SELECT COUNT(*) FROM $COMMENT_TABLE WHERE num_oid=$_OID AND num_pcode=$pcode AND num_mcode=$mcode AND num_main=$main)
			WHERE num_oid=$_OID AND num_pcode=$pcode AND num_mcode=$mcode AND num_serial=$main
		");
		$DB->commit();

		$sql = "update TAB_PARTY_MEMBER set num_comment=num_comment-1 where  num_oid=$_OID and num_pcode=$pcode and str_id='".$data[str_user]."'";
		$DB->query($sql);
		$DB->commit();

		$URL->delVar('main');
		//WebApp::redirect($URL->setVar(array('act'=>'party.board.read','id'=>$main)));
		WebApp::moveBack();
	} else {
		WebApp::moveBack('해당 글을 찾을 수 없습니다');
	}
} else {
	$data = array(id=>$id,page=>$page);

	if ($env['admin']) {
		$message = "나도 한마디를 삭제합니다.";
		$pass = $DB->sqlFetchOne("SELECT str_pass FROM $COMMENT_TABLE WHERE num_oid=$_OID AND num_pcode=$pcode AND num_mcode=$mcode AND num_main=$main AND num_serial=$id");
		$tpl->define("CONTENT", "html/party/board/skin/admin_del_confirm.htm");
		$tpl->assign('pass',$pass);
	} else {
		$message = "나도 한마디를 삭제하시려면 작성시 입력하셨던 패스워드를 입력하세요";
		$tpl->define("CONTENT", "html/party/board/skin/".$board_skin."/pass.htm");
		$tpl->assign($data);
	}
	$tpl->assign(array(
		'mcode'=>$mcode,
		'main'=>$main,
		'id'=>$id,
		'message'=>$message
	));
}
?>
