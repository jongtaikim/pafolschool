<?
//2008-01-04 ����
/**********************************
���ο� �б� ������ �ǽð� a/s

���α׷� : ���� 
������ : ��ȭ
**********************************/

//$aaaip = explode(".",$_SERVER[REMOTE_ADDR]);


if($_OID == "20189" ) {
	echo '<script>alert("���� ����Ʈ�� �̿��� �� �����ϴ�.");</script>';
	echo '<script>self.close();</script>';
	
		
exit;
}

$tpl->setLayout('admin'); // ���̾ƿ��� ����
$tpl->define("CONTENT", WebApp::getTemplate("admin/chet.htm"));

if(_OID == 1) { //2008-01-21 ���� ���� Ȩ������

 $tpl->assign(array('organ'=>"������"));



}else{
	
$DB = &WebApp::singleton("DB");







  
$sql2 = "select str_organ from tab_organ where num_oid = '$_OID' ";
$organ = $DB -> sqlFetchOne($sql2);


$title= $organ."�� ä�ù濡 ��û�� ���Խ��ϴ�.";

	$email = "now17@nate.com";
	$email2 = "master@hkedu.co.kr";
	$rmail = "now17@nate.com";
	$name="A/S ü��";

	$mail_header = "From: $name <$rmail>\n";
	$mail_header .= "Reply-to: $rmail\n";
	$mail_header .= "MIME-Version: 1.0\n";
	$mail_header .= "Content-Type: text/html; charset=euc-kr\n";
	$mail_header .= "X-Mailer: INNOMEDISYS Mailer\n";


	
		$cont="
					A/S ä�ù濡 ��û�� ���Խ��ϴ�.
			";
	

	mail($email,$title,$cont,$mail_header);
	mail($email2,$title,$cont,$mail_header);


        $tpl->assign(array('organ'=>$organ));





}


	

    if(check_edumark_ip()) {
       $tpl->assign(array('organ'=>"A/S������"));
    }

?>

