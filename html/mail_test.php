<?




$title="test mail�Դϴ�.";

	$email = "now17@e-wut.com";
	
	$rmail = "now17@e-wut.com";
	$name="A/S ü��";

	$mail_header = "From: $name <$rmail>\n";
	$mail_header .= "Reply-to: $rmail\n";
	$mail_header .= "MIME-Version: 1.0\n";
	$mail_header .= "Content-Type: text/html; charset=euc-kr\n";
	$mail_header .= "X-Mailer: INNOMEDISYS Mailer\n";


	
		$cont="
					A/S ü�ù濡 ��û�� ���Խ��ϴ�.
			";
	

	if(mail($email,$title,$cont,$mail_header)){
		echo "�߼�";
	}else{
		echo "����";
	}

echo "adasd";

?>