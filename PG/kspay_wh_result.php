<? mb_http_input("euc-kr"); mb_http_output("euc-kr"); ?>
<? include "./KSPayWebHost.inc"; ?>
<?
    $rcid       = $_POST["reWHCid"];
    $rctype     = $_POST["reWHCtype"];
    $rhash      = $_POST["reWHHash"];

	$ipg = new KSPayWebHost($rcid, null);

	$authyn		= "";
	$trno		= "";
	$trddt		= "";
	$trdtm		= "";
	$amt		= "";
	$authno		= "";
	$msg1		= "";
	$msg2		= "";
	$ordno		= "";
	$isscd		= "";
	$aqucd		= "";
	$temp_v		= "";
	$result		= "";

	$resultcd =  "";

	//��ü���� �߰��Ͻ� ���ڰ��� �޴� �κ��Դϴ�
	$a =  $_POST["a"]; 
	$b =  $_POST["b"]; 
	$c =  $_POST["c"]; 
	$d =  $_POST["d"];

	if ($ipg->kspay_send_msg("1"))
	{
		$authyn	 = $ipg->kspay_get_value("authyn");
		$trno	 = $ipg->kspay_get_value("trno"  );
		$trddt	 = $ipg->kspay_get_value("trddt" );
		$trdtm	 = $ipg->kspay_get_value("trdtm" );
		$amt	 = $ipg->kspay_get_value("amt"   );
		$authno	 = $ipg->kspay_get_value("authno");
		$msg1	 = $ipg->kspay_get_value("msg1"  );
		$msg2	 = $ipg->kspay_get_value("msg2"  );
		$ordno	 = $ipg->kspay_get_value("ordno" );
		$isscd	 = $ipg->kspay_get_value("isscd" );
		$aqucd	 = $ipg->kspay_get_value("aqucd" );
		$temp_v	 = "";
		$result	 = $ipg->kspay_get_value("result");

		if (!empty($authyn) && 1 == strlen($authyn))
		{
			if ($authyn == "O")
			{
				$resultcd = "0000";
			}else
			{
				$resultcd = trim($authno);
			}

			//$ipg->kspay_send_msg("3"); // ����ó���� �Ϸ�Ǿ��� ��� ȣ���մϴ�.(�� ������ ������ �Ͻ������� kspay_send_msg("1")�� ȣ���Ͽ� �ŷ����� ��ȸ�� �����մϴ�.)
		}
	}
?>
<html>
<head>
<meta http-equiv="Cache-Control" content="no-cache"> 
<meta http-equiv="Pragma" content="no-cache"> 
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<title>*** KSNET WebHost ��� [PHP] ***</title>
<link href="http://kspay.ksnet.to/store/KSPayFlashV1.3/mall/css/pgstyle.css" rel="stylesheet" type="text/css" charset="euc-kr">
</head>
<script language="javascript">
// �ſ�ī�� ������ ��� ��ũ��Ʈ
function receiptView(tr_no)
{
	receiptWin = "http://nims.ksnet.co.kr/pg_infoc/src/bill/credit_view.jsp?tr_no="+tr_no;
    window.open(receiptWin , "" , "scrollbars=no,width=434,height=700");
}

// ���ݿ����� ��� ��ũ��Ʈ
function CashreceiptView(tr_no)
{
    receiptWin = "http://nims.ksnet.co.kr/pg_infoc/src/bill/ps1.jsp?s_pg_deal_numb="+tr_no;
    window.open(receiptWin , "" , "scrollbars=no,width=434,height=580");
}

-->
</script>

<body>
<table width="560" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="50" align="right" background="http://kspay.ksnet.to/store/KSPayFlashV1.3/mall/imgs/bg_top.gif" class="txt_pd1">KSNET WebHost ��� [PHP]</td>
  </tr>
  <tr>
    <td height="530" valign="top" background="http://kspay.ksnet.to/store/KSPayFlashV1.3/mall/imgs/bg_man.gif">	
	<table width="560" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="25">&nbsp;</td>
        <td width="505" align="center">
		<table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td height="40" style="padding:0px 0px 0px 15px; "><img src="http://kspay.ksnet.to/store/KSPayFlashV1.3/mall/imgs/ico_tit5.gif" width="30" height="30" align="absmiddle"> <strong>����׸�</strong></td>
      </tr>
      <tr>
        <td align="center"><table width="400" border="0" cellspacing="0" cellpadding="0">
          <tr bgcolor="#FFFFFF">
            <td width="120"><img src="http://kspay.ksnet.to/store/KSPayFlashV1.3/mall/imgs/ico_right.gif" width="11" height="11" align="absmiddle"> �������</td>
            <td width="280">
<?
						if (empty($result) || 4 != strlen($result))
						{
							echo("(???)");
						}else
						{
							switch (substr($result,0,1))
							{
								case '1' : echo("�ſ�ī��"			); break;
								case 'I' : echo("�ſ�ī��"			); break;
								case '2' : echo("�ǽð�������ü"	); break;
								case '6' : echo("������¹߱�"		); break; 
								case 'M' : echo("�޴�������"		); break; 
								default  : echo("(????)"			); break; 
							}
						}
?>
            </td>
          </tr>
          <tr bgcolor="#E3E3E3"> <td height="1" colspan="2"></td> </tr>

          <tr bgcolor="#FFFFFF">
            <td width="120"><img src="http://kspay.ksnet.to/store/KSPayFlashV1.3/mall/imgs/ico_right.gif" width="11" height="11" align="absmiddle"> ��������</td>
            <td width="280"><?echo($authyn)?>(<? if(!empty($authyn) && "O" == $authyn) echo("���μ���"); else echo("���ΰ���"); ?>) <font color=red> :�������ΰ��� ���� �빮�� O,X�Դϴ�. </font></td>
          </tr>
          <tr bgcolor="#E3E3E3"> <td height="1" colspan="2"></td> </tr>
          <tr bgcolor="#FFFFFF">
            <td width="120"><img src="http://kspay.ksnet.to/store/KSPayFlashV1.3/mall/imgs/ico_right.gif" width="11" height="11" align="absmiddle"> �����ڵ�</td>
            <td width="280"><?echo($resultcd)?></td>
          </tr>
          <tr bgcolor="#E3E3E3"> <td height="1" colspan="2"></td> </tr>
          <tr bgcolor="#FFFFFF">
            <td width="120"><img src="http://kspay.ksnet.to/store/KSPayFlashV1.3/mall/imgs/ico_right.gif" width="11" height="11" align="absmiddle"> �ֹ���ȣ</td>
            <td width="280"><?echo($ordno)?></td>
          </tr>
          <tr bgcolor="#E3E3E3"> <td height="1" colspan="2"></td> </tr>
          <tr bgcolor="#FFFFFF">
            <td width="120"><img src="http://kspay.ksnet.to/store/KSPayFlashV1.3/mall/imgs/ico_right.gif" width="11" height="11" align="absmiddle"> �ݾ�</td>
            <td width="280"><?echo($amt)?></td>
          </tr>
          <tr bgcolor="#E3E3E3"> <td height="1" colspan="2"></td> </tr>
          <tr bgcolor="#FFFFFF">
            <td width="120"><img src="http://kspay.ksnet.to/store/KSPayFlashV1.3/mall/imgs/ico_right.gif" width="11" height="11" align="absmiddle"> �ŷ���ȣ</td>
            <td width="280"><?echo($trno)?> <font color=red>:KSNET���� �ο��� ������ȣ�Դϴ�. </font></td>
          </tr>
          <tr bgcolor="#E3E3E3"> <td height="1" colspan="2"></td> </tr>
          <tr bgcolor="#FFFFFF">
            <td width="120"><img src="http://kspay.ksnet.to/store/KSPayFlashV1.3/mall/imgs/ico_right.gif" width="11" height="11" align="absmiddle"> �ŷ�����</td>
            <td width="280"><?echo($trddt)?></td>
          </tr>
          <tr bgcolor="#E3E3E3"> <td height="1" colspan="2"></td> </tr>
          <tr bgcolor="#FFFFFF">
            <td width="120"><img src="http://kspay.ksnet.to/store/KSPayFlashV1.3/mall/imgs/ico_right.gif" width="11" height="11" align="absmiddle"> �ŷ��ð�</td>
            <td width="280"><?echo($trdtm)?></td>
          </tr>
          <tr bgcolor="#E3E3E3"> <td height="1" colspan="2"></td> </tr>
<? if (!empty($authyn) && "O" == $authyn) { ?>
          <tr bgcolor="#FFFFFF">
            <td width="120"><img src="http://kspay.ksnet.to/store/KSPayFlashV1.3/mall/imgs/ico_right.gif" width="11" height="11" align="absmiddle"> ī��� ���ι�ȣ/���� �ڵ��ȣ</td>
            <td width="280"><?echo($authno)?><font color=red>:ī��翡�� �ο��� ��ȣ�� �����Ѱ��� �ƴմϴ�. </font></td>
          </tr>
          <tr bgcolor="#E3E3E3"> <td height="1" colspan="2"></td> </tr>
<? } ?>
          <tr bgcolor="#FFFFFF">
            <td width="120"><img src="http://kspay.ksnet.to/store/KSPayFlashV1.3/mall/imgs/ico_right.gif" width="11" height="11" align="absmiddle"> �߱޻��ڵ�/������¹�ȣ/������ü��ȣ</td>
            <td width="280"><?echo($isscd)?></td>
          </tr>
          <tr bgcolor="#E3E3E3"> <td height="1" colspan="2"></td> </tr>
          <tr bgcolor="#FFFFFF">
            <td width="120"><img src="http://kspay.ksnet.to/store/KSPayFlashV1.3/mall/imgs/ico_right.gif" width="11" height="11" align="absmiddle"> ���Ի��ڵ�</td>
            <td width="280"><?echo($aqucd)?></td>
          </tr>
          <tr bgcolor="#E3E3E3"> <td height="1" colspan="2"></td> </tr>
          <tr bgcolor="#FFFFFF">
            <td width="120"><img src="http://kspay.ksnet.to/store/KSPayFlashV1.3/mall/imgs/ico_right.gif" width="11" height="11" align="absmiddle"> �޽���1</td>
            <td width="280"><?echo($msg1)?></td>
          </tr>
          <tr bgcolor="#E3E3E3"> <td height="1" colspan="2"></td> </tr>
          <tr bgcolor="#FFFFFF">
            <td width="120"><img src="http://kspay.ksnet.to/store/KSPayFlashV1.3/mall/imgs/ico_right.gif" width="11" height="11" align="absmiddle"> �޽���2</td>
            <td width="280"><?echo($msg2)?></td>
          </tr>
          <tr bgcolor="#E3E3E3"> <td height="1" colspan="2"></td> </tr>

		<? if (!empty($authyn) && "O" == $authyn && "1" == substr($trno,0,1)) { ?> <!-- ��������� ��츸 ���������: �ſ�ī���� ��츸 ���� -->
          <tr bgcolor="#FFFFFF">
            <td width="400" colspan="2" align="center"> <input type="button" value="���������" onClick="javascript:receiptView('<?echo($trno)?>')"> </td>
          </tr>
          <tr bgcolor="#E3E3E3"> <td height="1" colspan="2"></td> </tr>
      	<? } ?>
        </table></td>
      </tr>
    </table>
		</td>
        <td width="30">&nbsp;</td>
      </tr>
    </table>
	</td>
  </tr>
  <tr>
    <td height="37" background="http://kspay.ksnet.to/store/KSPayFlashV1.3/mall/imgs/bg_bot.gif">&nbsp;</td>
  </tr>
</table>
</body>
</html>
