<?
/**************************************
* ���ϸ�: del_comment.php
* �ۼ���: 2002-12-26
* �ۼ���: ��ģ����
* ��  ��: �ڸ�Ʈ ����
***************************************/

// ��� �� ������ �Ѵ�. -��-;;

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


if ($id === false) WebApp::moveBack('�ش� ���� �������� �ʽ��ϴ�');
if ($pass) {


	$data = $DB->sqlFetch("SELECT str_pass FROM $COMMENT_TABLE WHERE $que num_mcode=$mcode AND num_main=$main AND num_serial=$id");
	if ($pass != $data['str_pass']) WebApp::moveBack("�н����尡 ��ġ���� �ʽ��ϴ�");

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
		WebApp::moveBack('�ش� ���� ã�� �� �����ϴ�');
	}
} else {
	$data = array(id=>$id,page=>$page);

	if ($env['admin']) {
		$message = "���� �Ѹ��� �����մϴ�.";
		$pass = $DB->sqlFetchOne("SELECT str_pass FROM $COMMENT_TABLE WHERE $que num_mcode=$mcode AND num_main=$main AND num_serial=$id");
		$tpl->define("CONTENT", WebApp::getTemplate("board/skin/admin_del_confirm.htm"));
		$tpl->assign('pass',$pass);
	} else {
		$message = "���� �Ѹ��� �����Ͻ÷��� �ۼ��� �Է��ϼ̴� �н����带 �Է��ϼ���";
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
