<?




$title="test mail입니다.";

	$email = "now17@e-wut.com";
	
	$rmail = "now17@e-wut.com";
	$name="A/S 체팅";

	$mail_header = "From: $name <$rmail>\n";
	$mail_header .= "Reply-to: $rmail\n";
	$mail_header .= "MIME-Version: 1.0\n";
	$mail_header .= "Content-Type: text/html; charset=euc-kr\n";
	$mail_header .= "X-Mailer: INNOMEDISYS Mailer\n";


	
		$cont="
					A/S 체팅방에 요청이 들어왔습니다.
			";
	

	if(mail($email,$title,$cont,$mail_header)){
		echo "발송";
	}else{
		echo "실패";
	}

echo "adasd";

?>