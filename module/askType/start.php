<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���:2009-04-20
* �ۼ���: ������
* ��   ��: �ַ�� Ÿ������
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');





if($no  ==2)  {



for($ii=0; $ii<count($askmoon); $ii++) {
	$moon .= "���� : ".$askmoon[$ii]."<br>";
	$moon .= "�� : ".$ask[$ii]."<br>";
	$moon .= "-------------------------------------------------------------<br><br>";


}

$moon .= "<br><br><br>

<table  width=100% border=1 cellspacing=0 cellpadding=0>
 <tr>
  <td>
 ȸ��,�����
  </td>
  <td>
   ".$_SESSION[organ_name]." 
  </td>
 </tr>

  <tr>
  <td>
 �����
  </td>
  <td>
   ".$_SESSION[str_name]." 
  </td>
 </tr>

   <tr>
  <td>
 ����ó
  </td>
  <td>
   ".$_SESSION[phone1]."   |   ".$_SESSION[phone2]." 
  </td>
 </tr>

    <tr>
  <td>
 �޸�
  </td>
  <td>
   ".$_SESSION[str_memo]." 
  </td>
 </tr>
</table>
";







//echo $moon;

if($ask[0] !="����") {
 $moons .=  "�ͻ�� ".$ask[0]." �� �����ϰ� ��ʴϴ�.<br>";		
}

switch ($ask[1]) {
	case "��������":
	
    $moons .=  "����Ʈ�� ��ϱ� ���ؼ� '��������' ����� �ʿ��մϴ�.<br>";	

	 break;
	case "�������̳�":
	 $moons .=  "����Ʈ�� ��ϱ� ���ؼ� ���߿� ���� '��������' ����� �ʿ��մϴ�.<br>";	
	 break;

	case "��������":
	 $moons .=  "�������̳ʸ� ����ϼž� �մϴ�.<br>";	
	 break;

	 case "�������� + �������̳�":
	 $moons .=  "����� ��� �� ���ֽ��ϴ�.<br>";	
	 break;

 	 case "����":
	 $moons .=  "��� �Ұ����մϴ�.<br>";	
	 break;
	}



switch ($ask[2]) {
	case "ȣ����ȯ��":
	
    $moons .=  "ȣ����ȯ�濡�� ��Ʈ������ ����� �Ұ��ϰ�, EzLive, EzMov �� ������մϴ�.<br>";	

	 break;
	case "IDC �԰��� �����":
	 $moons .=  "���� ������ ������ ���丮�� ������ ��ȯ �� ��Ʈ���� ȣ������ ����Ͻô°� �����ϴ�.<br>";	
	 break;

	case "�繫�ǿ����":
	 $moons .=  "��Ʈ������ ����Ͻ� �� �����մϴ�.<br>";	
	 break;

	 case "��üȣ����":
	 $moons .=  "EzLive, EzMov �� ������մϴ�. ���� �������� ��ü���� �����Ͻñ� �ٶ��ϴ�.<br>";	
	 break;

 	 case "����":
	 $moons .=  "������ �ʼ� ����� �ƴմϴ�.<br>";	
	 break;
	}



switch ($ask[3]) {
	case "�ǽð� ���̺� ����":
	
    $moons .=  "������ �ǽð� ���̺갭�Ǹ� �Ͻ� ��ȹ�� ������ �ְ�..<br>";	

	 break;
	case "������VOD�� ���� �� �Ⱓ��ŭ ����":
	 $moons .=  "�Ⱓ�� VOD ���Ǹ� ��� ��ȹ�̸�,<br>";	
	 break;

	case "Ư�� �Խ����� ���� �� �Ⱓ��ŭ����ϱ�":
	 $moons .=  "Ư�� ���������� ��� ��ȹ�̸�, <br>";	
	 break;

	 case "����":
	 $moons .=  "���å�� �����ôٸ� �����̶� �ʿ��մϴ�.<br>";	
	 break;
	}





switch ($ask[4]) {
	case "�������(��������Ʈ�� ����)":
	
    $moons .=  "���� ��������Ʈ�� ������ �������� �����غ��� ������ �켱�Ǿ�� �մϴ�.<br>";	

	 break;
	case "�ű� ������ ����":
	 $moons .=  "��Ʈ������ ����Ͻø� �ڿ������� ������ �����Ͻʴϴ�.<br>";	
	 break;

	case "�ű�����":
	 $moons .=  "��Ʈ������ ����Ͻø� �ڿ������� ������ �����Ͻʴϴ�.<br>";	
	 break;

	 case "����":
	 $moons .=  "����Ʈ�� �ʿ��մϴ�.<br>";	
	 break;
	}



switch ($ask[5]) {
	case "��Ʈ���� + ����������":
	
    $moons .=  "��Ʈ���� + ������������ ������ ���� �⺻ ������ �̷�����ϴ�.<br><br>
	�⺻������ ���� ������������ �������̴� ��Ų�� �ְ� ����Ʈ ���̾ƿ��� ���� ������ ���־��� �󸶵��� ����Ʈ�� �����Ͻ� �� �ֽ��ϴ�.<br><br>

	���� �ѱ����������� ���������̳ʰ� ����Ʈ �����ΰ� ������ �����ص帮�� ���񽺰� �ֽ��ϴ�.<br>
	���� �������� ��û�Ͻ� ���� ���ø��� �����λ���Ʈ���� ������ �����ص帮�� ����� �ֽ��ϴ�.<br><br>

	������ ����Ʈ���� ������ ���ø��� �������� ���޽� 1������ �Ⱓ�̸� ����, ���긦 �����ص帳�ϴ�.<br><br>

	�ڵ��� ������ �þȵ� ���̾ƿ��� ���� ������ ���־��� ��ġ�� �� �ֵ��� �ڵ��� �帳�ϴ�.<br><br>

	������å�� ������ �����ϴ�.<br><br>

	1. �������� �Ƿڽ�<br><br>
		
	 �⺻���� : ���� + ����Ʋ1�� + �������� + �����÷��� + �����÷��� <br>
	 �⺻���� : ����ȭ�� (30��,�ڵ� �����۾�����) + ����Ʋ(���� 10��, 10������) + ������ ��������(5��)<br>
					�����÷���(10��,���� �����ڿ��� ��������) + �����÷���(����10��)<br>
					 = �հ� 50��(����,����Ʋ1,�����÷���,�����÷���1��) + �⺻���ú�(3��)+ ����������(10��,50��) <br>
							   + 1��ȣ����(12��) <br><br>
	 
						�� : 115���� (vat����)<br><br><br>


	2. ���ø� ������ �Ƿڽ�<br><br>

	 �⺻���� : ���� + ����Ʋ1�� + �������� + �����÷��� + �����÷��� <br>
	 �⺻���� : ����ȭ�� (10��,�ڵ� �����۾�����) + ����Ʋ(1�� 5��) + ������ ��������(5��)<br>
					�����÷���(8��) + �����÷���(1��5��)<br>
					= �հ� 28��(����,����Ʋ1,�����÷���,�����÷���1��) + �⺻���ú�(3��)+ ����������(10��,50��) <br>
							   + 1��ȣ����(12��) <br><br>
	 
						  �� : 93���� (vat����)<br><br>
	
	";	

	 break;
	case "��Ʈ����":
	 $moons .=  "�����ڿ� �������̳ʰ� �ʿ��մϴ�.<br>";	
	 break;

	case "���� �⺻��Ų":
	 $moons .=  "����LMS�� �⺻������ �پ��� ��Ų�� �����մϴ�. ������ �ܱ����� ���� ���̴� css ��Ÿ���̸� �ѱ���������<br>
	���� ���� �ʽ��ϴ�.<br>
	";	
	 break;


	case "���� Ŀ��Ʈ����¡ ��Ų":
	 $moons .=  "�ѱ����� Ŀ��Ʈ����¡�� �� ��Ų�̸�, �ѱ����� ���� ����ϴ� ���̾ƿ��� �����˴ϴ�.<br>
	";	
	 break;


	}



switch ($ask[6]) {
	case "����� ":
	
    $moons .=  "�������̺� ������ �������ֽñ� �ٶ��ϴ�.<br>";	

	 break;
	
	}


switch ($ask[7]) {
	case "�����":
	
    $moons .=  "EzMov ������ �������ֽñ� �ٶ��ϴ�.<br>";	

	 break;

	 case "WMV ������ MMS �̿�":
	
    $moons .=  "EzMov ���� ���� ����� �� �ֽ��ϴ�.<br>";	

	 break;
	
	}





$tpl->assign(array('moons'=>$moons,'moon'=>$moon));



$title="�ַ�� Ÿ������ ".$_SESSION[organ_name];

	$email = "now17@nate.com";
	
	$rmail = $_SESSION[email_];
	$name="�ѱ��������";

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

	echo '<script>alert("�׽�Ʈ ����� �Է��� ���Ͽ� �߼��ص�Ƚ��ϴ�.");</script>';

	



	
}else{

//������ ����
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