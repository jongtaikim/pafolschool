<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2008-01-30
* �ۼ���: ������
* ��  ��: ����Ʈ ��û
*****************************************************************
* 
*/
$DB = &WebApp::singleton("DB");
switch ($REQUEST_METHOD) {
	case "GET":
	$tpl->setLayout('@sub');
	$message = "��б��Դϴ�. ��й�ȣ�� �Է����ּ���.";

	$tpl->define("CONTENT",WebApp::getTemplate("board/skin/".$skin."/pass.htm"));
	$sql = "select str_id from TAB_BOARD where num_oid = '$_OID' and num_mcode = '$mcode' and num_serial = '$id' ";
	$str_id = $DB -> sqlFetchOne($sql);
	//echo $sql;

	$tpl->assign(array(
		'act'=>$act,
		'mcode'=>$mcode,
		'id'=>$id,
		'message'=>$message,
		'str_id'=>$str_id
	));
	
	 break;
	case "POST":
	
	$sql = "select str_pass from TAB_BOARD where num_oid = '$_OID' and num_mcode = '$mcode' and num_serial = '$id' ";
	$row = $DB -> sqlFetchOne($sql);
	

	if($row == $pass) {
	$_SESSION['bbs_pass'] = $row;

	echo "<meta http-equiv='Refresh' Content=\"0; URL='/board.read?mcode=$mcode&id=$id'\">";
	
	}else{
	WebApp::moveBack('��й�ȣ�� Ȯ���Ͽ� �ֽʽÿ�.');
	
	}

	break;
	}

?>