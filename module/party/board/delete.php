<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: module/party/board/delete.php
* �ۼ���: 2006-05-16
* �ۼ���: �̹���
* ��  ��: 
*****************************************************************
* 
*/
$id = $_REQUEST['id'];
$pass = $_REQUEST['pass'];

//$PERM->apply('party',$pcode.'.'.$mcode,'w');
$DB = &WebApp::singleton('DB');

if ($id === false) WebApp::moveBack('�ش� ���� �������� �ʽ��ϴ�');
if ($pass) {

	$data = $DB->sqlFetchArray("
				SELECT 
					str_user, str_pass,num_step,num_group,num_depth,str_text,str_thumb
				FROM
					$ARTICLE_TABLE
				WHERE 
					num_oid=$_OID AND
                    num_pcode=$pcode AND
					num_mcode=$mcode AND
					num_serial=$id");
	if ($pass != $data['str_pass']) WebApp::moveBack('�н����尡 ��ġ���� �ʽ��ϴ�');

	

	if ($data['num_depth'] == 0) {
		$query = "SELECT COUNT(*) FROM $ARTICLE_TABLE WHERE num_oid=$_OID AND num_pcode=$pcode AND num_mcode=$mcode AND num_group=".$data[num_group]." AND num_step>".$data[num_step];
		if($DB->sqlFetchOne($query) > 1) WebApp::moveBack('����� �ִ� �������� ������ �� �����ϴ�');
	}

	$sql = "DELETE FROM $ARTICLE_TABLE WHERE num_oid=$_OID AND num_pcode=$pcode AND num_mcode=$mcode AND num_serial=$id";
	if ($DB->query($sql)) {
		// �ش� �ۿ� ���� �� �� �۾��� ���� ; ���Ǫ�� ( 2004�� 05�� 03�� )
		$sql = "DELETE FROM $COMMENT_TABLE WHERE num_oid=$_OID AND num_pcode=$pcode AND num_mcode=$mcode AND num_main=$id";
		$DB->query($sql);

		// �Ǵٸ� ����� �ִ� ����� ������ �� �Ʒ� ��۵��� �Ѵܰ� ����ø�
		$pstep = $data['num_step'];
		$sql = "UPDATE $ARTICLE_TABLE SET num_depth=num_depth-1 WHERE num_oid=$_OID AND num_pcode=$pcode AND num_mcode=$mcode AND num_serial=$id AND num_step > $pstep";
		$DB->query($sql);
		$DB->commit();

		// {{{ ÷������ ����
		$FH = &WebApp::singleton('FileHost','party',$pcode.'.'.$mcode);
        $FH->set_oid($_OID);
		$FH->delete_as_main($id);
		$FH->delete_as_html($data['str_text']->load());
		if($data['str_thumb']) $FH->del_thumb($data['str_thumb']);
		$FH->close();
		// }}}



		$sql = "update TAB_PARTY set num_board=num_board-1 where  num_oid=$_OID and num_pcode=$pcode";
		$DB->query($sql);
		$DB->commit();

		$sql = "update TAB_PARTY_MEMBER set num_board=num_board-1 where  num_oid=$_OID and num_pcode=$pcode and str_id='".$data['str_user']."'";
		$DB->query($sql);
		$DB->commit();

		WebApp::redirect("party.board.list?pcode=$pcode&mcode=$mcode");
	} else {
		WebApp::moveBack('�ش� ���� ã�� �� �����ϴ�');
	}
} else {
	if ($env['admin'] == true){
		$message = "�Խù��� �����մϴ�.";
		$pass = $DB->sqlFetchOne("SELECT str_pass FROM $ARTICLE_TABLE WHERE num_oid=$_OID AND num_pcode=$pcode AND num_mcode=$mcode AND num_serial=$id");
		$tpl->define("CONTENT","html/party/board/skin/admin_del_confirm.htm");
		$tpl->assign('pass',$pass);
	} else {
		$message = "���� �����Ͻ÷��� �α��� �н����带 �Է��ϼ���";
		$tpl->define("CONTENT","html/party/board/skin/".$board_skin."/pass.htm");
		$tpl->assign($data);
	}
	$tpl->assign(array(
		'act'=>$act,
		'mcode'=>$mcode,
		'id'=>$id,
		'message'=>$message
	));
}
?>
