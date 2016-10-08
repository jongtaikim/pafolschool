<?
/**************************************
* 파일명: del_comment.php
* 작성일: 2002-12-26
* 작성자: 거친마루
* 설  명: 코멘트 삭제
***************************************/

// 요거 좀 만져야 한다. -ㅛ-;;

$act = $_REQUEST['act'];
$id = $_REQUEST['id'];
$pass = $_REQUEST['pass'];
$main = $_REQUEST['main'];
$DB = &WebApp::singleton('DB');

if($mcode < 900000) {
$que = " num_oid = '$_OID' and ";
}else{
$que = "";
}


if ($id === false) WebApp::moveBack('해당 글이 존재하지 않습니다');
if ($pass) {


	$data = $DB->sqlFetch("SELECT str_pass FROM $COMMENT_TABLE WHERE $que num_mcode=$mcode AND num_main=$main AND num_serial=$id");
	if ($pass != $data['str_pass']) WebApp::moveBack("패스워드가 일치하지 않습니다");

	$sql = "DELETE FROM $COMMENT_TABLE WHERE $que num_mcode=$mcode AND num_main=$main AND num_serial=$id";

	if ($DB->query($sql)) {
		$DB->commit();
		$DB->query("
			UPDATE $ARTICLE_TABLE SET
				num_comment=(SELECT COUNT(*) FROM $COMMENT_TABLE WHERE num_oid=$oid AND num_mcode=$mcode AND num_main=$main)
			WHERE $que num_mcode=$mcode AND num_serial=$main
		");
		$DB->commit();
		$URL->delVar('main');
		WebApp::redirect($URL->setVar(array('act'=>'board.read','id'=>$main)));
	} else {
		WebApp::moveBack('해당 글을 찾을 수 없습니다');
	}
} else {
	$data = array(id=>$id,page=>$page);

	if ($env['admin']) {
		$message = "나도 한마디를 삭제합니다.";
		$pass = $DB->sqlFetchOne("SELECT str_pass FROM $COMMENT_TABLE WHERE $que num_mcode=$mcode AND num_main=$main AND num_serial=$id");
		$tpl->define("CONTENT", WebApp::getTemplate("board/skin/admin_del_confirm.htm"));
		$tpl->assign('pass',$pass);
	} else {
		$message = "나도 한마디를 삭제하시려면 작성시 입력하셨던 패스워드를 입력하세요";
		$tpl->define("CONTENT", WebApp::getTemplate("board/skin/${skin}/pass.htm"));
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
