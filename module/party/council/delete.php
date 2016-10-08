<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/party/council/delete.php
* 작성일: 2006-05-17
* 작성자: 이범민
* 설  명: 삭제
*****************************************************************
* 
*/
$PERM->apply('party',$pcode.'.'.$mcode,'w');

if (!$id) WebApp::moveBack('잘못된 요청입니다.');
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
// ID 체크
if (!$env['admin'] && (!$_SESSION['USERID'] || $_SESSION['USERID'] != $data['str_user'])) {
	WebApp::moveBack("로그인하지 않았거나 회원님이 작성하신 글이 아닙니다.");
}

if ($data['num_depth'] == 0) {
	$query = "SELECT COUNT(*) FROM ".TAB_PARTY_COUNCIL." WHERE num_oid=$_OID AND num_pcode=$pcode AND num_mcode=$mcode AND num_group=".$data[num_group]." AND num_step<".$data[num_step];
	if($DB->sqlFetchOne($query) > 0) WebApp::moveBack('답글이 있는 원본글은 삭제할 수 없습니다');
}

if ($_REQUEST['confirm']) {
	$sql = "DELETE FROM ".TAB_PARTY_COUNCIL." WHERE num_oid=$_OID AND num_pcode=$pcode AND num_mcode=$mcode AND num_serial=$id";
	if ($DB->sqlQuery($sql)) {
		// 또다른 답글이 있는 답글을 지울경우 그 아래 답글들을 한단계 끌어올림
		$sql = "UPDATE ".TAB_PARTY_COUNCIL." SET num_depth=num_depth-1 WHERE num_oid=$_OID AND num_mcode=$mcode AND num_serial=$id AND num_step > ".$data['num_step'];
		$DB->sqlQuery($sql);
		$DB->commit();

		// 첨부파일 삭제 및 첨부파일 기록 삭제
		$FH = &WebApp::singleton('FileHost','party',$pcode.'.'.$mcode);
		$FH->delete_as_main($id);
		$FH->delete_as_html($data['str_text1'].$data['str_text2'].$data['str_text3']);
		$FH->close();

		$URL->delVar('id');
		WebApp::redirect($URL->setVar('act',"party.council.list"));
	} else {
		WebApp::moveBack('해당 글을 찾을 수 없습니다');
	}
} else {
	$tpl->define("CONTENT","html/party/council/skin/${skin}/confirm.htm");
	$tpl->assign($data);
	$tpl->parse("CONTENT");
}
?>
