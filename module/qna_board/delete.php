<?
/**************************************
* 파일명: delete.php
* 작성일: 2002-12-26
* 작성자: 거친마루
* 설  명: 게시물 삭제
***************************************/

$id = $_REQUEST['id'];
$pass = $_REQUEST['pass'];

$DB = &WebApp::singleton("DB");
$sql = "select str_pass from TAB_BOARD where num_oid = '$_OID' and num_mcode = '$mcode' and str_user = '".$USERID."' ";
$pass1 = $DB -> sqlFetchOne($sql);
//echo $pass;

$tpl->assign(array('pass'=>$pass1));



$PERM->apply('menu',$mcode,'w');
$DB = &WebApp::singleton('DB');



// 2007-09-17 귀찮아서 더이상 쿼리 이원화 안함 2007-09-17 종태

	if($mcode < 900000) {
		$que = "num_oid=$oid AND";
	}else{
	$que = "";
	}
	

if ($id === false) WebApp::moveBack('해당 글이 존재하지 않습니다');
if ($pass) {

	
	if($mcode >= "900000") {
		
		$data = $DB->sqlFetchArray("
				SELECT 
					str_pass,num_step,num_group,num_depth,str_text1,str_text2,str_text3,str_thumb
				FROM
					$ARTICLE_TABLE
				WHERE 
					
					num_mcode=$mcode AND
					num_serial=$id");

	}else{
	
	$data = $DB->sqlFetchArray("
				SELECT 
					str_pass,num_step,num_group,num_depth,str_text1,str_text2,str_text3,str_thumb
				FROM
					$ARTICLE_TABLE
				WHERE 
					num_oid=$oid AND
					num_mcode=$mcode AND
					num_serial=$id");
	}

	

	if ($pass != $data['str_pass']) WebApp::moveBack('패스워드가 일치하지 않습니다');

	if ($data['num_depth'] == 0) {
		
		
		if($mcode >="900000") {

	$query = "SELECT COUNT(*) FROM $ARTICLE_TABLE WHERE  num_mcode=$mcode AND num_group=".$data[num_group]." AND num_step>".$data[num_step];

		}else{
		
	$query = "SELECT COUNT(*) FROM $ARTICLE_TABLE WHERE num_oid=$oid AND num_mcode=$mcode AND num_group=".$data[num_group]." AND num_step>".$data[num_step];
		
		}



		
		
		
		if($DB->sqlFetchOne($query) > 1) WebApp::moveBack('답글이 있는 원본글은 삭제할 수 없습니다');
	}


	
	

	
	
	
	$sql = "DELETE FROM $ARTICLE_TABLE WHERE $que num_mcode=$mcode AND num_serial=$id";
	if ($DB->query($sql)) {
		// 해당 글에 대한 한 줄 글쓰기 삭제 ; 얼룩푸우 ( 2004년 05월 03일 )
		$sql = "DELETE FROM $COMMENT_TABLE WHERE $que num_mcode=$mcode AND num_main=$id";
		$DB->query($sql);

		// 또다른 답글이 있는 답글을 지울경우 그 아래 답글들을 한단계 끌어올림
		$pstep = $data['num_step'];
		$sql = "UPDATE $ARTICLE_TABLE SET num_depth=num_depth-1 WHERE $que num_mcode=$mcode AND num_serial=$id AND num_step > $pstep";
		$DB->query($sql);
		$DB->commit();





		// {{{ 첨부파일 삭제
		$FH = &WebApp::singleton('FileHost','menu',$mcode);
        $FH->set_oid($oid);
		$FH->delete_as_main($id);
		$FH->delete_as_html($data['str_text1'].$data['str_text2'].$data['str_text3']);
		if($data['str_thumb']) $FH->del_thumb($data['str_thumb']);
		$FH->close();
		// }}}

        if($env['use_recent']) {
            $FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
            $FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/inc.main.latestboard.'.$env['listtype'].'.htm');
        }

		$URL->delVar('id');
		WebApp::redirect($URL->setVar('act',".list"));
	} else {
		WebApp::moveBack('해당 글을 찾을 수 없습니다');
	}
} else {
	//$PERM = &WebApp::singleton('Permission');
	if ($env['admin'] == true){// || $PERM->check('x')) {
		$message = "게시물을 삭제합니다.";
		$pass = $DB->sqlFetchOne("SELECT str_pass FROM $ARTICLE_TABLE WHERE $que num_mcode=$mcode AND num_serial=$id");
	
		$tpl->define("CONTENT",WebApp::getTemplate("board/skin/admin_del_confirm.htm"));
		$tpl->assign('pass',$pass);
	} else {
		$message = "글을 삭제하시려면 작성시 입력하셨던 패스워드를 입력하세요";
		$tpl->define("CONTENT",WebApp::getTemplate("board/skin/${skin}/pass.htm"));
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