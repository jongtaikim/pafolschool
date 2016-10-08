<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-03-25
* 작성자: 김종태
* 설  명: 사이트 신청관련 메일 보내기
*****************************************************************
* 
*/

	$r_mail = "master@hkedu.co.kr";
	$email = $rmail;
	$name= "한국교육개발";
	$title = $oname."홈페이지 제작 진행 상태 안내 메일";

	$mail_header = "From: $name <$rmail>\n";
	$mail_header .= "Reply-to: $r_mail\n";
	$mail_header .= "MIME-Version: 1.0\n";
	$mail_header .= "Content-Type: text/html; charset=euc-kr\n";
	$mail_header .= "X-Mailer: INNOMEDISYS Mailer\n";

switch ($str_mail) {
	case "1":
	

	$contttt = "
	신청하신 내용을 확인 하였습니다. <br>
	<br>
	학교의 임시 사이트는 2~3일내에 만들어지며 자료이관 작업과 도메인 변경은 2~3주 정도 걸립니다.
	<br>
	학교소개부분은 추가 디자인을 신청 하시면 디자인을 해 작성하지만 신청을 안하 실 경우<br>
	이전 디자인을 이관 해드립니다.<br>

	<br>
	언제나 노력하는 한국교육개발 되겠습니다. <br> 감사합니다.
	";

	 break;
	case "2":

	$contttt = "
	홈페이지 제작에 필요한 기본자료를 요청합니다.<br>
	<br>
	요청 자료는 다음과 같습니다.
	<br><br>
	1. 학교장 선생님 인사말 및 증명사진<br>
	2. 학교 현황 자료<br>
	3. 학교 상징 자료<br>
	4. 학교 교직원 현황 자료<br>
	5. 교육목표자료<br>
	6. 약도 자료<br>
	7. 기타 추가 페이지 자료<br>
	

	<br>
	언제나 노력하는 한국교육개발 되겠습니다. <br> 감사합니다.
	";

	
	break;


	case "3":

	$contttt = "
	임시 사이트 도메인을 안내해드립니다.<br>
	<br><br><br>
	<a href = 'http://$host_ff' target='_blank'><b style='color:blue'>$host_ff</b></a>
	<br>
	관리자모드
	<br>
	<a href = 'http://".$host_ff."/admin.main' target='_blank'><b style='color:red'>http://".$host_ff."/admin.main'</b></a>
	<br>
	<br>비밀번호는 isch2008 입니다. 
	비밀번호는 관리자 모드 환경설정에서 변경 가능합니다.<br>

	언제나 노력하는 한국교육개발 되겠습니다. <br> 감사합니다.
	";

	
	break;


		case "4":

	$contttt = "
	자료이관 및 세팅 작업이 완료했습니다.<br>
	아래 사이트에서 확인 하실 수 있습니다.<br>
	선생님이 임시사이트에 내용을 보고 완료를 해주시면 도메인 변경 작업에 들어갑니다.<br>
	선생님의 연락을 기다리고 있겠습니다.(연락처 : 031-427-0126~8 | 담당: 최인설 이사)
	<br><br><br>
	<a href = 'http://$host_ff' target='_blank'><b style='color:blue'>$host_ff</b></a>
	<br><br><br>

	언제나 노력하는 한국교육개발 되겠습니다. <br> 감사합니다.
	";

	
	break;


	case "5":

	$contttt = "
	
	$oname 학교 홈페이지가 서비스 종료일이 다가옵니다.<br>
	서비스 종료일이 지나면 이지스쿨 관리자모드를 사용할 권한이 없어집니다.<br>
    연장을 원하시면 연락 주세요
	<br><br><br>
	(연락처 : 031-427-0126~8 | 담당: 최인설 이사)
	<br><br><br>

	언제나 노력하는 한국교육개발 되겠습니다. <br> 감사합니다.
	";

	
	break;



	case "6":

$title = $mail_title;

if(mail($email,$title,$cont,$mail_header)){

echo '<script>alert("메일이 발송되었습니다.");</script>';

WebApp::moveBack();
exit;
}
	break;

	}







	
$cont="

<style>
a {
	selector-dummy : expression(this.hideFocus=true);
}

a:link {
	color: #000000;
	text-decoration:none;
}

a:visited {
	color: #000000;
	text-decoration:none;
}

a:active {
	color:red;
	text-decoration:none;
}

a:hover {
	color:red;
	text-decoration:none;
}
</style>
<TABLE width = 540 height = 468 align = center background = http://main.hkedu.co.kr/mail.gif >
<TR>
	<TD  style = padding:60px >

<TABLE align = center>
<TR>
	<TD 'stye = font-size:11px'> $contttt
	</TD>
</TR>
</TABLE>

</TD>
</TR>
<tr>
  <td bgcolor = #000000 height = 15 align = right style = padding-right:10px><a href = http://www.hkedu.co.kr style = color:#ffffff;font-size:11px target=_blank>사이트 바로가기</a></td>
</tr>
</TABLE>

";
	






	if(mail($email,$title,$cont,$mail_header)){

echo '<script>alert("메일이 발송되었습니다.");</script>';

	WebApp::moveBack();
	
	}
?>