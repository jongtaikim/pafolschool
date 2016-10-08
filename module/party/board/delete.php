<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/party/board/delete.php
* 작성일: 2006-05-16
* 작성자: 이범민
* 설  명: 
*****************************************************************
* 
*/
$id = $_REQUEST['id'];
$pass = $_REQUEST['pass'];

//$PERM->apply('party',$pcode.'.'.$mcode,'w');
$DB = &WebApp::singleton('DB');

if ($id === false) WebApp::moveBack('해당 글이 존재하지 않습니다');
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
	if ($pass != $data['str_pass']) WebApp::moveBack('패스워드가 일치하지 않습니다');

	

	if ($data['num_depth'] == 0) {
		$query = "SELECT COUNT(*) FROM $ARTICLE_TABLE WHERE num_oid=$_OID AND num_pcode=$pcode AND num_mcode=$mcode AND num_group=".$data[num_group]." AND num_step>".$data[num_step];
		if($DB->sqlFetchOne($query) > 1) WebApp::moveBack('답글이 있는 원본글은 삭제할 수 없습니다');
	}

	$sql = "DELETE FROM $ARTICLE_TABLE WHERE num_oid=$_OID AND num_pcode=$pcode AND num_mcode=$mcode AND num_serial=$id";
	if ($DB->query($sql)) {
		// 해당 글에 대한 한 줄 글쓰기 삭제 ; 얼룩푸우 ( 2004년 05월 03일 )
		$sql = "DELETE FROM $COMMENT_TABLE WHERE num_oid=$_OID AND num_pcode=$pcode AND num_mcode=$mcode AND num_main=$id";
		$DB->query($sql);

		// 또다른 답글이 있는 답글을 지울경우 그 아래 답글들을 한단계 끌어올림
		$pstep = $data['num_step'];
		$sql = "UPDATE $ARTICLE_TABLE SET num_depth=num_depth-1 WHERE num_oid=$_OID AND num_pcode=$pcode AND num_mcode=$mcode AND num_serial=$id AND num_step > $pstep";
		$DB->query($sql);
		$DB->commit();

		// {{{ 첨부파일 삭제
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
		WebApp::moveBack('해당 글을 찾을 수 없습니다');
	}
} else {
	if ($env['admin'] == true){
		$message = "게시물을 삭제합니다.";
		$pass = $DB->sqlFetchOne("SELECT str_pass FROM $ARTICLE_TABLE WHERE num_oid=$_OID AND num_pcode=$pcode AND num_mcode=$mcode AND num_serial=$id");
		$tpl->define("CONTENT","html/party/board/skin/admin_del_confirm.htm");
		$tpl->assign('pass',$pass);
	} else {
		$message = "글을 삭제하시려면 로그인 패스워드를 입력하세요";
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
