<?
/**************************************
* ���ϸ�: delete.php
* �ۼ���: 2002-12-26
* �ۼ���: ��ģ����
* ��  ��: �Խù� ����
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



// 2007-09-17 �����Ƽ� ���̻� ���� �̿�ȭ ���� 2007-09-17 ����

	if($mcode < 900000) {
		$que = "num_oid=$oid AND";
	}else{
	$que = "";
	}
	

if ($id === false) WebApp::moveBack('�ش� ���� �������� �ʽ��ϴ�');
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

	

	if ($pass != $data['str_pass']) WebApp::moveBack('�н����尡 ��ġ���� �ʽ��ϴ�');

	if ($data['num_depth'] == 0) {
		
		
		if($mcode >="900000") {

	$query = "SELECT COUNT(*) FROM $ARTICLE_TABLE WHERE  num_mcode=$mcode AND num_group=".$data[num_group]." AND num_step>".$data[num_step];

		}else{
		
	$query = "SELECT COUNT(*) FROM $ARTICLE_TABLE WHERE num_oid=$oid AND num_mcode=$mcode AND num_group=".$data[num_group]." AND num_step>".$data[num_step];
		
		}



		
		
		
		if($DB->sqlFetchOne($query) > 1) WebApp::moveBack('����� �ִ� �������� ������ �� �����ϴ�');
	}


	
	

	
	
	
	$sql = "DELETE FROM $ARTICLE_TABLE WHERE $que num_mcode=$mcode AND num_serial=$id";
	if ($DB->query($sql)) {
		// �ش� �ۿ� ���� �� �� �۾��� ���� ; ���Ǫ�� ( 2004�� 05�� 03�� )
		$sql = "DELETE FROM $COMMENT_TABLE WHERE $que num_mcode=$mcode AND num_main=$id";
		$DB->query($sql);

		// �Ǵٸ� ����� �ִ� ����� ������ �� �Ʒ� ��۵��� �Ѵܰ� ����ø�
		$pstep = $data['num_step'];
		$sql = "UPDATE $ARTICLE_TABLE SET num_depth=num_depth-1 WHERE $que num_mcode=$mcode AND num_serial=$id AND num_step > $pstep";
		$DB->query($sql);
		$DB->commit();





		// {{{ ÷������ ����
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
		WebApp::moveBack('�ش� ���� ã�� �� �����ϴ�');
	}
} else {
	//$PERM = &WebApp::singleton('Permission');
	if ($env['admin'] == true){// || $PERM->check('x')) {
		$message = "�Խù��� �����մϴ�.";
		$pass = $DB->sqlFetchOne("SELECT str_pass FROM $ARTICLE_TABLE WHERE $que num_mcode=$mcode AND num_serial=$id");
	
		$tpl->define("CONTENT",WebApp::getTemplate("board/skin/admin_del_confirm.htm"));
		$tpl->assign('pass',$pass);
	} else {
		$message = "���� �����Ͻ÷��� �ۼ��� �Է��ϼ̴� �н����带 �Է��ϼ���";
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