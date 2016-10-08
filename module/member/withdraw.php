<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/member/withdraw.php
* 작성일: 2006-01-19
* 작성자: 서종석
* 설  명: 회원 탈퇴
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

				$DB->query("DELETE FROM ".BS_MEMBER." WHERE num_oid=$_OID AND str_id='$userid'");//메인 회원테이블에서 정보 삭제
                $DB->commit();
				$DB->query("DELETE FROM ".BS_MEMBER_.$u_type." WHERE num_oid=$_OID AND str_id='$userid'");//추가 회원테이블에서 정보 삭제
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

				WebApp::redirect("member.logout","탈퇴 처리되었습니다. 그동안 이용해주셔서 감사합니다.");
			} else WebApp::moveBack('입력하신 비밀번호가 가입시 비밀번호와 일치하지 않습니다');

		}else WebApp::moveBack('가입시 등록한 주민등록번호(사업자등록번호)가 아닙니다');
		break;
}
?>