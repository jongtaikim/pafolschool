<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2008-10-27
* �ۼ���: ������
* ��   ��: ��ü���� ������
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');


switch ($REQUEST_METHOD) {
	case "GET":
	
	$mem_types = WebApp::get('member',array('key'=>'member_types'));
	//��ȸ��, �����ڵ��� ���Ը�Ͽ��� ����
	unset($mem_types['z'],$mem_types['n'],$mem_types['c'],$mem_types['d'],$mem_types['x']);

	$tpl->assign(array('mem_types'=>$mem_types));
	
	


	$tpl->setLayout('no3');
	$tpl->define("CONTENT", Display::getTemplate("member/admin/all_mail.htm"));
	
	 break;
	case "POST":


$mtypes = substr($mtypes,0,strlen($mtypes)-1);
$mtypes = explode(";",$mtypes);
	
$mtypes_in = "'".implode("','",$mtypes)."'";

$content = WebApp::ImgChaneDe($cont);

$sql = "select str_email from TAB_MEMBER where num_oid = $_OID and chr_mtype in ($mtypes_in)";


$hp = $DB -> sqlFetchAll($sql);

for($ii=0; $ii<count($hp); $ii++) {
		$mail_header = "From: $name <$rmail>\n";
		$mail_header .= "Reply-to: $rmail\n";
		$mail_header .= "MIME-Version: 1.0\n";
		$mail_header .= "Content-Type: text/html; charset=euc-kr\n";
		$mail_header .= "X-Mailer: INNOMEDISYS Mailer\n";

		if(mail($hp[$ii][str_email],$title,$cont,$mail_header)){
		echo "�߼�";
		}else{
		echo "mail ".$hp[$ii][str_email].",$title,$cont,$mail_header <br><br>";
		}
}

echo '<script>alert("'.count($hp).'�� �߼� �Ϸ�");</script>';
//WebApp::moveBack();




	 break;
	}

?>