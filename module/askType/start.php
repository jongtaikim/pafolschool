<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일:2009-04-20
* 작성자: 김종태
* 설   명: 솔루션 타입조사
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');





if($no  ==2)  {



for($ii=0; $ii<count($askmoon); $ii++) {
	$moon .= "문제 : ".$askmoon[$ii]."<br>";
	$moon .= "답 : ".$ask[$ii]."<br>";
	$moon .= "-------------------------------------------------------------<br><br>";


}

$moon .= "<br><br><br>

<table  width=100% border=1 cellspacing=0 cellpadding=0>
 <tr>
  <td>
 회사,기관명
  </td>
  <td>
   ".$_SESSION[organ_name]." 
  </td>
 </tr>

  <tr>
  <td>
 담당자
  </td>
  <td>
   ".$_SESSION[str_name]." 
  </td>
 </tr>

   <tr>
  <td>
 연락처
  </td>
  <td>
   ".$_SESSION[phone1]."   |   ".$_SESSION[phone2]." 
  </td>
 </tr>

    <tr>
  <td>
 메모
  </td>
  <td>
   ".$_SESSION[str_memo]." 
  </td>
 </tr>
</table>
";







//echo $moon;

if($ask[0] !="없음") {
 $moons .=  "귀사는 ".$ask[0]." 을 소유하고 계십니다.<br>";		
}

switch ($ask[1]) {
	case "직접관리":
	
    $moons .=  "사이트를 운영하기 위해서 '유지보수' 계약이 필요합니다.<br>";	

	 break;
	case "웹디자이너":
	 $moons .=  "사이트를 운영하기 위해서 개발에 관한 '유지보수' 계약이 필요합니다.<br>";	
	 break;

	case "웹개발자":
	 $moons .=  "웹디자이너를 고용하셔야 합니다.<br>";	
	 break;

	 case "웹개발자 + 웹디자이너":
	 $moons .=  "충분히 운영하 실 수있습니다.<br>";	
	 break;

 	 case "없음":
	 $moons .=  "운영이 불가능합니다.<br>";	
	 break;
	}



switch ($ask[2]) {
	case "호스팅환경":
	
    $moons .=  "호스팅환경에선 울트라웹의 사용은 불가하고, EzLive, EzMov 는 운영가능합니다.<br>";	

	 break;
	case "IDC 입고후 직접운영":
	 $moons .=  "기존 서버는 데이터 스토리지 서버로 전환 후 울트라웹 호스팅을 사용하시는게 좋습니다.<br>";	
	 break;

	case "사무실에서운영":
	 $moons .=  "울트라웹을 사용하실 걸 권장합니다.<br>";	
	 break;

	 case "업체호스팅":
	 $moons .=  "EzLive, EzMov 는 운영가능합니다. 연동 가능한지 업체측에 문의하시기 바랍니다.<br>";	
	 break;

 	 case "없음":
	 $moons .=  "서버는 필수 사양이 아닙니다.<br>";	
	 break;
	}



switch ($ask[3]) {
	case "실시간 라이브 강의":
	
    $moons .=  "앞으로 실시간 라이브강의를 하실 계획을 가지고 있고..<br>";	

	 break;
	case "동영상VOD를 결제 후 기간만큼 보기":
	 $moons .=  "기간제 VOD 강의를 운영할 계획이며,<br>";	
	 break;

	case "특정 게시판을 결제 후 기간만큼사용하기":
	 $moons .=  "특정 유료계시판을 운영할 계획이며, <br>";	
	 break;

	 case "없음":
	 $moons .=  "운영정책이 없으시다면 지금이라도 필요합니다.<br>";	
	 break;
	}





switch ($ask[4]) {
	case "구축안함(기존사이트가 있음)":
	
    $moons .=  "먼저 기존사이트에 연동이 가능한지 조사해보는 업무가 우선되어야 합니다.<br>";	

	 break;
	case "신규 리뉴얼 예정":
	 $moons .=  "울트라웹을 사용하시면 자연스러운 연동이 가능하십니다.<br>";	
	 break;

	case "신규제작":
	 $moons .=  "울트라웹을 사용하시면 자연스러운 연동이 가능하십니다.<br>";	
	 break;

	 case "없음":
	 $moons .=  "사이트가 필요합니다.<br>";	
	 break;
	}



switch ($ask[5]) {
	case "울트라웹 + 디자인제작":
	
    $moons .=  "울트라웹 + 디자인제작은 다음과 같이 기본 견적이 이루어집니다.<br><br>
	기본적으로 저희가 디자인툴에서 제공들이는 스킨이 있고 사이트 레이아웃과 각각 영역에 구애없이 얼마든지 사이트를 구성하실 수 있습니다.<br><br>

	저희 한국교육개발은 전문디자이너가 사이트 디자인과 구성을 대행해드리는 서비스가 있습니다.<br>
	직접 디자인을 요청하실 경우와 템플릿을 디자인사이트에서 구매후 적용해드리는 방법이 있습니다.<br><br>

	디자인 사이트에서 구매한 템플릿은 저희측에 전달시 1주정도 기간이면 메인, 서브를 적용해드립니다.<br><br>

	코딩된 디자인 시안도 레이아웃과 각각 영역에 구애없이 배치할 수 있도록 코딩해 드립니다.<br><br>

	가격정책은 다음과 같습니다.<br><br>

	1. 디자인을 의뢰시<br><br>
		
	 기본구성 : 메인 + 서브틀1개 + 웹페이지 + 메인플래시 + 서브플래시 <br>
	 기본견적 : 메인화면 (30만,코딩 위젯작업포함) + 서브틀(개당 10만, 10개까지) + 디자인 웹페이지(5만)<br>
					메인플래시(10만,사진 관리자에서 수정가능) + 서브플래시(개당10만)<br>
					 = 합계 50만(메인,서브틀1,메인플래시,서브플래시1개) + 기본세팅비(3만)+ 서브페이지(10개,50만) <br>
							   + 1년호스팅(12만) <br><br>
	 
						총 : 115만원 (vat별도)<br><br><br>


	2. 템플릿 구매후 의뢰시<br><br>

	 기본구성 : 메인 + 서브틀1개 + 웹페이지 + 메인플래시 + 서브플래시 <br>
	 기본견적 : 메인화면 (10만,코딩 위젯작업포함) + 서브틀(1개 5만) + 디자인 웹페이지(5만)<br>
					메인플래시(8만) + 서브플래시(1개5만)<br>
					= 합계 28만(메인,서브틀1,메인플래시,서브플래시1개) + 기본세팅비(3만)+ 서브페이지(10개,50만) <br>
							   + 1년호스팅(12만) <br><br>
	 
						  총 : 93만원 (vat별도)<br><br>
	
	";	

	 break;
	case "울트라웹":
	 $moons .=  "개발자와 웹디자이너가 필요합니다.<br>";	
	 break;

	case "무들 기본스킨":
	 $moons .=  "무들LMS는 기본적으로 다양한 스킨을 제공합니다. 하지만 외국에서 많이 쓰이는 css 스타일이며 한국정서에는<br>
	조금 맞지 않습니다.<br>
	";	
	 break;


	case "무들 커스트마이징 스킨":
	 $moons .=  "한국형에 커스트마이징이 들어간 스킨이며, 한국에서 많이 사용하는 레이아웃이 제공됩니다.<br>
	";	
	 break;


	}



switch ($ask[6]) {
	case "사용함 ":
	
    $moons .=  "이지라이브 견적을 문의해주시기 바랍니다.<br>";	

	 break;
	
	}


switch ($ask[7]) {
	case "사용함":
	
    $moons .=  "EzMov 견적을 문의해주시기 바랍니다.<br>";	

	 break;

	 case "WMV 윈도우 MMS 이용":
	
    $moons .=  "EzMov 보다 조금 비싸질 수 있습니다.<br>";	

	 break;
	
	}





$tpl->assign(array('moons'=>$moons,'moon'=>$moon));



$title="솔루션 타입조사 ".$_SESSION[organ_name];

	$email = "now17@nate.com";
	
	$rmail = $_SESSION[email_];
	$name="한국교육계발";

	$mail_header = "From: $name <$rmail>\n";
	$mail_header .= "Reply-to: $rmail\n";
	$mail_header .= "MIME-Version: 1.0\n";
	$mail_header .= "Content-Type: text/html; charset=euc-kr\n";
	$mail_header .= "X-Mailer: INNOMEDISYS Mailer\n";


	
		$cont="
					$moon <br><br><br><br> $moons
			";
	

	mail($email,$title,$cont,$mail_header);


	mail($rmail,$title,$cont,$mail_header);

	echo '<script>alert("테스트 결과를 입력한 메일에 발송해드렸습니다.");</script>';

	



	
}else{

//참여자 정보
if($organ_name) $_SESSION[organ_name] = $organ_name;
if($str_name)$_SESSION[str_name]= $str_name;
if($phone1)$_SESSION[phone1]= $phone1;
if($phone2)$_SESSION[phone2]= $phone2;
if($str_memo)$_SESSION[str_memo]= $str_memo;
if($email_) $_SESSION[email_] = $email_;
}

$tpl->assign(array('no'=>$no));
$tpl->setLayout('admin');
$tpl->define("CONTENT", Display::getTemplate("askType/start.htm"));
	


?>