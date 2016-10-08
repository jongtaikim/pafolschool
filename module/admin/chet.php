<?
//2008-01-04 종태
/**********************************
새로운 학교 관리자 실시간 a/s

프로그램 : 종태 
디자인 : 선화
**********************************/

//$aaaip = explode(".",$_SERVER[REMOTE_ADDR]);


if($_OID == "20189" ) {
	echo '<script>alert("샘플 사이트는 이용할 수 없습니다.");</script>';
	echo '<script>self.close();</script>';
	
		
exit;
}

$tpl->setLayout('admin'); // 레이아웃은 서브
$tpl->define("CONTENT", WebApp::getTemplate("admin/chet.htm"));

if(_OID == 1) { //2008-01-21 종태 본사 홈페이지

 $tpl->assign(array('organ'=>"본사운영자"));



}else{
	
$DB = &WebApp::singleton("DB");







  
$sql2 = "select str_organ from tab_organ where num_oid = '$_OID' ";
$organ = $DB -> sqlFetchOne($sql2);


$title= $organ."이 채팅방에 요청이 들어왔습니다.";

	$email = "now17@nate.com";
	$email2 = "master@hkedu.co.kr";
	$rmail = "now17@nate.com";
	$name="A/S 체팅";

	$mail_header = "From: $name <$rmail>\n";
	$mail_header .= "Reply-to: $rmail\n";
	$mail_header .= "MIME-Version: 1.0\n";
	$mail_header .= "Content-Type: text/html; charset=euc-kr\n";
	$mail_header .= "X-Mailer: INNOMEDISYS Mailer\n";


	
		$cont="
					A/S 채팅방에 요청이 들어왔습니다.
			";
	

	mail($email,$title,$cont,$mail_header);
	mail($email2,$title,$cont,$mail_header);


        $tpl->assign(array('organ'=>$organ));





}


	

    if(check_edumark_ip()) {
       $tpl->assign(array('organ'=>"A/S관리자"));
    }

?>

