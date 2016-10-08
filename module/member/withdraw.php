<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: module/member/withdraw.php
* �ۼ���: 2006-01-19
* �ۼ���: ������
* ��  ��: ȸ�� Ż��
*****************************************************************
* 
*/
WebApp::import('Auth');
Auth::require_login();

switch (REQUEST_METHOD) {
	case 'GET':
		$tpl->setLayout('@myinfo');
		$tpl->define('CONTENT', Display::getTemplate('member/withdraw.htm'));
		break;
	case 'POST':
		$DB = &WebApp::singleton('DB');
		$number = $_REQUEST['p_id'];
		$passwd = $_REQUEST['pass'];
		$userid = $_SESSION['USERID'];
		$u_type = $_SESSION['TYPE'];
		
		$memo = $DB->sqlFetch("
					SELECT 
						/*+INDEX(".BS_MEMBER." ".IDX_BS_MEMBER_REGNO.")*/ str_id,str_passwd 
					FROM 
						".BS_MEMBER." 
					WHERE num_oid=$_OID AND str_regno='$number'
		");
		if(!strcmp($memo['str_id'],$userid)) {

			if(!strcmp($memo['str_passwd'],$passwd)) {

				$DB->query("DELETE FROM ".BS_MEMBER." WHERE num_oid=$_OID AND str_id='$userid'");//���� ȸ�����̺��� ���� ����
                $DB->commit();
				$DB->query("DELETE FROM ".BS_MEMBER_.$u_type." WHERE num_oid=$_OID AND str_id='$userid'");//�߰� ȸ�����̺��� ���� ����
                $DB->commit();
                $sql = "DELETE FROM ".BS_WISH_BOOK." WHERE num_oid=$_OID AND str_id='$userid'";
                $DB->query($sql);
                $DB->commit();
                $sql = "UPDATE ".BS_ORDER." SET str_id='NULL' WHERE num_oid=$_OID AND str_id='$userid'";
                $DB->query($sql);
                $DB->commit();
                $sql = "UPDATE ".BS_TMP_ONUM." SET str_id='NULL' WHERE num_oid=$_OID AND str_id='$userid'";
                $DB->query($sql);
                $DB->commit();
                $sql = "UPDATE ".BS_ORDER_BOOOK." SET str_id='NULL' WHERE num_oid=$_OID AND str_id='$userid'";
                $DB->query($sql);
                $DB->commit();
                $sql = "UPDATE ".BS_PAY_LOG." SET str_id='NULL' WHERE num_oid=$_OID AND str_id='$userid'";
                $DB->query($sql);
                $DB->commit();
                $sql = "UPDATE ".BS_BOARD_PRI." SET str_id='NULL' WHERE num_oid=$_OID AND str_id='$userid'";
                $DB->query($sql);
                $DB->commit();
                $sql = "UPDATE ".BS_FIND_PAYER." SET str_id='NULL' WHERE num_oid=$_OID AND str_id='$userid'";
                $DB->query($sql);
                $DB->commit();

				WebApp::redirect("member.logout","Ż�� ó���Ǿ����ϴ�. �׵��� �̿����ּż� �����մϴ�.");
			} else WebApp::moveBack('�Է��Ͻ� ��й�ȣ�� ���Խ� ��й�ȣ�� ��ġ���� �ʽ��ϴ�');

		}else WebApp::moveBack('���Խ� ����� �ֹε�Ϲ�ȣ(����ڵ�Ϲ�ȣ)�� �ƴմϴ�');
		break;
}
?>