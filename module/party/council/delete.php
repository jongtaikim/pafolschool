<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: module/party/council/delete.php
* �ۼ���: 2006-05-17
* �ۼ���: �̹���
* ��  ��: ����
*****************************************************************
* 
*/
$PERM->apply('party',$pcode.'.'.$mcode,'w');

if (!$id) WebApp::moveBack('�߸��� ��û�Դϴ�.');
$DB = &WebApp::singleton('DB');
$data = $DB->sqlFetchArray("
				SELECT 
					str_user,num_step,num_group,num_depth,str_text1,str_text2,str_text3
				FROM
					".TAB_PARTY_COUNCIL."
				WHERE 
					num_oid=$_OID AND
                    num_pcode=$pcode AND
					num_mcode=$mcode AND
					num_serial=$id");
// ID üũ
if (!$env['admin'] && (!$_SESSION['USERID'] || $_SESSION['USERID'] != $data['str_user'])) {
	WebApp::moveBack("�α������� �ʾҰų� ȸ������ �ۼ��Ͻ� ���� �ƴմϴ�.");
}

if ($data['num_depth'] == 0) {
	$query = "SELECT COUNT(*) FROM ".TAB_PARTY_COUNCIL." WHERE num_oid=$_OID AND num_pcode=$pcode AND num_mcode=$mcode AND num_group=".$data[num_group]." AND num_step<".$data[num_step];
	if($DB->sqlFetchOne($query) > 0) WebApp::moveBack('����� �ִ� �������� ������ �� �����ϴ�');
}

if ($_REQUEST['confirm']) {
	$sql = "DELETE FROM ".TAB_PARTY_COUNCIL." WHERE num_oid=$_OID AND num_pcode=$pcode AND num_mcode=$mcode AND num_serial=$id";
	if ($DB->sqlQuery($sql)) {
		// �Ǵٸ� ����� �ִ� ����� ������ �� �Ʒ� ��۵��� �Ѵܰ� ����ø�
		$sql = "UPDATE ".TAB_PARTY_COUNCIL." SET num_depth=num_depth-1 WHERE num_oid=$_OID AND num_mcode=$mcode AND num_serial=$id AND num_step > ".$data['num_step'];
		$DB->sqlQuery($sql);
		$DB->commit();

		// ÷������ ���� �� ÷������ ��� ����
		$FH = &WebApp::singleton('FileHost','party',$pcode.'.'.$mcode);
		$FH->delete_as_main($id);
		$FH->delete_as_html($data['str_text1'].$data['str_text2'].$data['str_text3']);
		$FH->close();

		$URL->delVar('id');
		WebApp::redirect($URL->setVar('act',"party.council.list"));
	} else {
		WebApp::moveBack('�ش� ���� ã�� �� �����ϴ�');
	}
} else {
	$tpl->define("CONTENT","html/party/council/skin/${skin}/confirm.htm");
	$tpl->assign($data);
	$tpl->parse("CONTENT");
}
?>
