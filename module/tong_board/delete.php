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


		$que = "num_oid=$oid AND";
	

if ($id === false) WebApp::moveBack('�ش� ���� �������� �ʽ��ϴ�');
if ($pass) {

	
	
	$data = $DB->sqlFetchArray("
				SELECT 
					str_pass,num_step,num_group,num_depth,str_text,str_thumb,str_mov,num_unix_time,str_user
				FROM
					$ARTICLE_TABLE
				WHERE 
					num_oid=$oid AND
					num_mcode=$mcode AND
					num_serial=$id");


	

	if ($pass != $data['str_pass']) WebApp::moveBack('�н����尡 ��ġ���� �ʽ��ϴ�');

	if ($data['num_depth'] == 0) {
		
		
	
		
	$query = "SELECT COUNT(*) FROM $ARTICLE_TABLE WHERE num_oid=$oid AND num_mcode=$mcode AND num_group=".$data[num_group]." AND num_step>".$data[num_step];
		
	



		
		
		
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

		
		//2008-11-10 ���� - �űԱ�, ��� ������ ����Ʈ ����
		if($data[str_user]){
			
			if($data[num_depth] > 0 )	$plus_point = "num_repaly_point";
			else	$plus_point = "num_board_point";

			$sql = "select $plus_point from TAB_ORGAN where num_oid = $_OID ";
			$chw = $DB -> sqlFetchOne($sql);
			
			//2008-11-10 ���� - �Խñ� ��Ͻ� ����Ʈ�� �Ϸ翡 2�Ǹ����� ����.
			$cdate = date("Ymd",$data[num_unix_time]);
			$sdate = mktime(0,0,0,substr($cdate,4,2),substr($cdate,6,2),substr($cdate,0,4));
			$edate = mktime(0,0,0,substr($cdate,4,2),substr($cdate,6,2)+1,substr($cdate,0,4));

			$sql = "select count(*) from $ARTICLE_TABLE where num_oid = $_OID and str_user = '".$data[str_user]."' and num_unix_time between $sdate and $edate";

			if($data[num_depth] > 0) $sql .= " and num_depth>0";	 //����ϰ�� ��۸� ó��
			else $sql .= " and num_depth=0"; //�ϹݰԽñ��ϰ�� ó��

			$bcnt = $DB -> sqlFetchOne($sql);

			if($bcnt <= 1){	//�Խñ��� �Ѱ��� ������ ���������Ƿ�, �Ѱ� ���ϰ� ���������� ����Ʈ ������Ŵ. (�ΰ��̻��� ������ ����Ʈ ������ �ʾ���.)
				$sql = "UPDATE ".TAB_MEMBER." SET $plus_point = $plus_point -1 , num_point_total = num_point_total - $chw WHERE num_oid=$_OID AND str_id='".$data[str_user]."'";
				$DB->query($sql);
				$DB->commit();
			}

		}


		// {{{ ÷������ ����
		$FH = &WebApp::singleton('FileHost','menu',$mcode);
        $FH->set_oid($oid);
		$FH->delete_as_main($id);
		$FH->delete_as_html($data['str_text']->load());
		if($data['str_thumb']) $FH->del_thumb($data['str_thumb']);
		$FH->close();
		// }}}


		function deleteCacheFiles($mcode) {
			$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));

				$FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/menu/smenu.htm');

				$_mcode = substr($mcode,0,2);
				$FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/menu/'.$_mcode.'.htm');
				$FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/menu/'.$mcode.'.htm');
				$FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/menu.xml');
				$FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/menu2.xml');
				$FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/cate.xml');
				$FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/url.xml');


				  $dellist=array();
				  $dellist[]="inc.main.out_bbs1.htm";
				  $dellist[]="inc.main.out_bbs2.htm";
				  $dellist[]="inc.main.out_bbs3.htm";
				  $dellist[]="inc.main.out_bbs4.htm";
				  $dellist[]="inc.main.out_bbs5.htm";
				

				for($ii=0; $ii<count($dellist); $ii++) {
				$FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/'.$dellist[$ii]);
				}

		}

		deleteCacheFiles($mcode);




		$URL->delVar('id');
		WebApp::redirect($URL->setVar('act',".list"));
	} else {
		WebApp::moveBack('�ش� ���� ã�� �� �����ϴ�');
	}
} else {
	//$PERM = &WebApp::singleton('Permission');
	if ($env['admin'] == true || $_SESSION[ADMIN_sub]){// || $PERM->check('x')) {
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