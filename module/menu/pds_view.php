<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2008-01-30
* �ۼ���: ������
* ��  ��: �����Ӹ�~!
*****************************************************************
* 
*/
$tpl = &WebApp::singleton('Display');
$DB = &WebApp::singleton('DB');

	

//2011-08-02 ���� send
if($REQUEST_METHOD == "POST"){

		$sql = "select * from ".TAB_PDS." where num_oid = "._OID." and num_mcode = '".$mcode."' ";
		$data =$DB -> sqlFetch($sql);
		
	
		$_SESSION[SEND_EMAIL] = $_POST[send_emails];
	
		$title=$data[str_title];
		$email = $_POST[send_emails];
		
		$rmail = "pds@"._DOMAIN;
		$name=_ONAME;
	
		$mail_header = "From: $name <$rmail>\n";
		$mail_header .= "Reply-to: $rmail\n";
		$mail_header .= "MIME-Version: 1.0\n";
		$mail_header .= "Content-Type: text/html; charset=euc-kr\n";
		$mail_header .= "X-Mailer: INNOMEDISYS Mailer\n";
		
		$data[str_text] = $data[str_text]."<br><br><a href='http://".$_SERVER[HTTP_HOST]."/hosts/".HOST."/doc/psd/".$mcode."/".$data[str_title]."'>".$data[str_title]." �ٿ�ε�</a>";
		
	

		$tpl->assign($data);
		$tpl->define('pds_main_W_',Display::getTemplate("mail/tpl.pds.htm"));
		$content = $tpl->fetch('pds_main_W_');
	
		$cont=$content;
		
	

		if(mail($email,$title,$cont,$mail_header)){
			WebApp::moveBack("�߼۵Ǿ����ϴ�.");
		}else{
			WebApp::moveBack("�߼� ���� �Ͽ����ϴ�.");
		}

 
}else{
	
//2011-08-02 ���� view
$sql = "select STR_REFILE as send_files from ".TAB_PDS." where num_oid = "._OID." and num_mcode = '".$param[mcode]."' ";
$data =$DB -> sqlFetch($sql);
$tpl->assign($data);


$template = $param['template'];
$tpl->define('emails_W_',$template);
$content = $tpl->fetch('emails_W_');
 echo $content ;

}

?>