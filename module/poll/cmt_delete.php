<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: module/poll/cmt_delete.php
* �ۼ���: 2005-03-25
* �ۼ���: �̹���
* ��  ��: 
*****************************************************************
* 
*/
$main = $_REQUEST['main'];
$id = $_REQUEST['id'];
if(!$main || !$id) WebApp::moveBack('�߸��� ��û�Դϴ�.');

switch($REQUEST_METHOD) {
	case "GET":
		$tpl->setLayout($layout);
		$tpl->define('CONTENT','html/poll/skin/'.$skin.'/cmt_delete.htm');
		$tpl->assign(array(
			'sect'=>$sect,
			'main'=>$main,
			'id'=>$id
		));

		//$PERM = &WebApp::singleton('Permission','main','poll');
		//if($PERM->check('x')) {
			$DB = &WebApp::singleton('DB');
			$sql = "SELECT STR_PASS FROM ".TAB_POLL_COMMENT." WHERE NUM_OID=$_OID AND NUM_MAIN=$main AND NUM_SERIAL=$id";
//			echo $sql ;
			if(!$passwd = $DB->sqlFetchOne($sql)) WebApp::raiseError('�ش� �Խù��� �������� �ʽ��ϴ�.');
			$tpl->assign('passwd',$passwd);
		//}
	break;
	case "POST":
		$passwd = $_POST['passwd'];
		if($passwd != '') {
			$DB = &WebApp::singleton('DB');
			$sql = "SELECT STR_PASS FROM ".TAB_POLL_COMMENT." WHERE NUM_OID=$_OID AND NUM_MAIN=$main AND NUM_SERIAL=$id";
			$cmp_passwd = $DB->sqlFetchOne($sql);
			if($passwd != $cmp_passwd) WebApp::moveBack('��й�ȣ�� ��ġ���� �ʽ��ϴ�.');

			$sql = "DELETE FROM ".TAB_POLL_COMMENT." WHERE NUM_OID=$_OID AND NUM_MAIN=$main AND NUM_SERIAL=$id";
			echo $sql ;
			if(!$DB->query($sql)) {
				WebApp::raiseError('�ش� �Խù��� �������� �ʽ��ϴ�.');
			} else {
				$DB->commit();
				WebApp::moveBack('�����Ǿ����ϴ�.');
				
			}
		} else {
			WebApp::raiseError('��й�ȣ�� �Է��Ͽ� �ֽʽÿ�.');
		}
	break;
}
?>