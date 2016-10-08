<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/member/findid.php
* 작성일: 2005-11-29
* 작성자: 이범민
* 설  명: id, 비밀번호찾기
*****************************************************************
* 
*/
switch($REQUEST_METHOD) {
	case "GET":
		
		if(!$mcode) $DOC_TITLE = "str:ID/비밀번호 찾기";
		$tpl->setLayout();
		$tpl->define('CONTENT',Display::getTemplate('member/findid.htm'));
	break;

	case "POST":
		

switch($mode) {
	case "id":


		
		$str_name	= trim($_POST['str_name']);
		$str_jumin	= trim($_POST['str_jumin1'])."-".$_POST['str_jumin2'];
		$str_email	= trim($_POST['str_email']);


		$DB = &WebApp::singleton('DB');
		$sql = "SELECT * FROM ".TAB_MEMBER." WHERE num_oid=$_OID AND str_name='$str_name' AND str_email='$str_email'";
		$data = $DB->sqlFetch($sql);
		$tpl->assign($data);

		
		if(!$mcode) $DOC_TITLE = "str:ID/비밀번호 찾기";
		$tpl->setLayout();
		$tpl->define('CONTENT',Display::getTemplate('member/findid_ok.htm'));

	break;

	case "pw":
	


		$str_name	= trim($_POST['str_name']);
		$str_jumin	= trim($_POST['str_jumin1'])."-".$_POST['str_jumin2'];
		$str_email	= trim($_POST['str_email']);
		

		$DB = &WebApp::singleton('DB');
		$sql = "SELECT * FROM ".TAB_MEMBER." WHERE num_oid=$_OID and str_id = '".$_POST['str_id']."' AND str_email='$str_email'";
		$data = $DB->sqlFetch($sql);
	
		

		if($data = $DB->sqlFetch($sql)) {



		$title= "학교홈페이지 비밀번호 지원";

		$email = $data['str_email'];
		


		$rmail = "Accounts-noreply@".DOMAIN_;
		$name=$_ONAME;

		$mail_header = "From: $name <$rmail>\n";
		$mail_header .= "Reply-to: $rmail\n";
		$mail_header .= "MIME-Version: 1.0\n";
		$mail_header .= "Content-Type: text/html; charset=euc-kr\n";
		$mail_header .= "X-Mailer: INNOMEDISYS Mailer\n";

		$cont=_ONAME."를 이용해주셔서 감사합니다.
	 

	문의하신 사용자 계정의 정보는 다음과 같습니다.
	- 아이디 :  ".$data['str_id']."
	- 비밀번호 : ".$data['str_passwd']."
	 

	요청하지 않았는데, 본 메일이 수신되었다면 비밀번호를 재설정하려는 다른 사용자가 실수로 이 이메일 주소를 입력했을 수 있습니다. 비밀번호 재설정 요청을 하지 않았으면 아무런 조치도 필요하지 않으며 이 메일을 무시하시면 됩니다.
	 

	※ 본 메일은 발신 전용 메일이므로 회신해도 답변 받을 수 없습니다.
	※ 추가 문의 사항은 "._ONAME." 담당자에게 문의하시기 바랍니다.";
			
		$cont= nl2br($cont);

		mail($email,$title,$cont,$mail_header);


		echo '<script>alert("회원가입시 입력했던 e-mail로 비밀번호를 보내드렸습니다. \n스팸편지함 까지 확인해주시기 바랍니다.");</script>';
		echo "<meta http-equiv='Refresh' Content=\"0; URL='member.login'\">";



		} else {
			WebApp::moveBack("입력하신 이름과 이메일이 일치하는 회원을 찾지 못하였습니다.\n 정확한 정보를 입력하여 주십시오.");
		}

	break;
	}	

	break;
}
?>