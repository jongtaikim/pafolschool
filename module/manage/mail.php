<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2008-03-25
* �ۼ���: ������
* ��  ��: ����Ʈ ��û���� ���� ������
*****************************************************************
* 
*/

	$r_mail = "master@hkedu.co.kr";
	$email = $rmail;
	$name= "�ѱ���������";
	$title = $oname."Ȩ������ ���� ���� ���� �ȳ� ����";

	$mail_header = "From: $name <$rmail>\n";
	$mail_header .= "Reply-to: $r_mail\n";
	$mail_header .= "MIME-Version: 1.0\n";
	$mail_header .= "Content-Type: text/html; charset=euc-kr\n";
	$mail_header .= "X-Mailer: INNOMEDISYS Mailer\n";

switch ($str_mail) {
	case "1":
	

	$contttt = "
	��û�Ͻ� ������ Ȯ�� �Ͽ����ϴ�. <br>
	<br>
	�б��� �ӽ� ����Ʈ�� 2~3�ϳ��� ��������� �ڷ��̰� �۾��� ������ ������ 2~3�� ���� �ɸ��ϴ�.
	<br>
	�б��Ұ��κ��� �߰� �������� ��û �Ͻø� �������� �� �ۼ������� ��û�� ���� �� ���<br>
	���� �������� �̰� �ص帳�ϴ�.<br>

	<br>
	������ ����ϴ� �ѱ��������� �ǰڽ��ϴ�. <br> �����մϴ�.
	";

	 break;
	case "2":

	$contttt = "
	Ȩ������ ���ۿ� �ʿ��� �⺻�ڷḦ ��û�մϴ�.<br>
	<br>
	��û �ڷ�� ������ �����ϴ�.
	<br><br>
	1. �б��� ������ �λ縻 �� �������<br>
	2. �б� ��Ȳ �ڷ�<br>
	3. �б� ��¡ �ڷ�<br>
	4. �б� ������ ��Ȳ �ڷ�<br>
	5. ������ǥ�ڷ�<br>
	6. �൵ �ڷ�<br>
	7. ��Ÿ �߰� ������ �ڷ�<br>
	

	<br>
	������ ����ϴ� �ѱ��������� �ǰڽ��ϴ�. <br> �����մϴ�.
	";

	
	break;


	case "3":

	$contttt = "
	�ӽ� ����Ʈ �������� �ȳ��ص帳�ϴ�.<br>
	<br><br><br>
	<a href = 'http://$host_ff' target='_blank'><b style='color:blue'>$host_ff</b></a>
	<br>
	�����ڸ��
	<br>
	<a href = 'http://".$host_ff."/admin.main' target='_blank'><b style='color:red'>http://".$host_ff."/admin.main'</b></a>
	<br>
	<br>��й�ȣ�� isch2008 �Դϴ�. 
	��й�ȣ�� ������ ��� ȯ�漳������ ���� �����մϴ�.<br>

	������ ����ϴ� �ѱ��������� �ǰڽ��ϴ�. <br> �����մϴ�.
	";

	
	break;


		case "4":

	$contttt = "
	�ڷ��̰� �� ���� �۾��� �Ϸ��߽��ϴ�.<br>
	�Ʒ� ����Ʈ���� Ȯ�� �Ͻ� �� �ֽ��ϴ�.<br>
	�������� �ӽû���Ʈ�� ������ ���� �ϷḦ ���ֽø� ������ ���� �۾��� ���ϴ�.<br>
	�������� ������ ��ٸ��� �ְڽ��ϴ�.(����ó : 031-427-0126~8 | ���: ���μ� �̻�)
	<br><br><br>
	<a href = 'http://$host_ff' target='_blank'><b style='color:blue'>$host_ff</b></a>
	<br><br><br>

	������ ����ϴ� �ѱ��������� �ǰڽ��ϴ�. <br> �����մϴ�.
	";

	
	break;


	case "5":

	$contttt = "
	
	$oname �б� Ȩ�������� ���� �������� �ٰ��ɴϴ�.<br>
	���� �������� ������ �������� �����ڸ�带 ����� ������ �������ϴ�.<br>
    ������ ���Ͻø� ���� �ּ���
	<br><br><br>
	(����ó : 031-427-0126~8 | ���: ���μ� �̻�)
	<br><br><br>

	������ ����ϴ� �ѱ��������� �ǰڽ��ϴ�. <br> �����մϴ�.
	";

	
	break;



	case "6":

$title = $mail_title;

if(mail($email,$title,$cont,$mail_header)){

echo '<script>alert("������ �߼۵Ǿ����ϴ�.");</script>';

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
  <td bgcolor = #000000 height = 15 align = right style = padding-right:10px><a href = http://www.hkedu.co.kr style = color:#ffffff;font-size:11px target=_blank>����Ʈ �ٷΰ���</a></td>
</tr>
</TABLE>

";
	






	if(mail($email,$title,$cont,$mail_header)){

echo '<script>alert("������ �߼۵Ǿ����ϴ�.");</script>';

	WebApp::moveBack();
	
	}
?>