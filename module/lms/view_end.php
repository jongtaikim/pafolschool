<? include "/home/kunetworks/user/PG/KSPayApprovalCancel.inc"; ?>
<?
	/* �������� �� ��ſ��Լ��� KSPayApprovalCancel.inc ���Ͽ� ��Ƴ��ҽ��ϴ�.*/

	//����Ÿ��	 : A-�������½���, N-��������, M-Visa3D��������, I-ISP�������� 
	$certitype			= $_POST["certitype"] ;	

//Header�� Data --------------------------------------------------
	$EncType				= "2" ;					//0: ��ȭ����, 1:ssl, 2: seed
	$Version				= "0603" ;				//��������
	$Type					= "00" ;				//����
	$Resend					= "0" ;					//���۱��� : 0 : ó��,  2: ������
	$RequestDate			=						// ��û���� : yyyymmddhhmmss
		SetZero(strftime("%Y"),4).
		SetZero(strftime("%m"),2).
		SetZero(strftime("%d"),2).
		SetZero(strftime("%H"),2).
		SetZero(strftime("%M"),2).
		SetZero(strftime("%S"),2);

	$KeyInType			= "K" ;						//KeyInType ���� : S : Swap, K: KeyInType
	$LineType			= "1" ;						//lineType 0 : offline, 1:internet, 2:Mobile
	$ApprovalCount		= "1"	;					//���ս��ΰ���
	$GoodType			= "0" ;						//��ǰ���� 0 : �ǹ�, 1 : ������
	$HeadFiller			= ""	;					//����

	$StoreId			= $_POST["storeid"] ;		//*�������̵�
	$OrderNumber		= $_POST["ordernumber"] ;	//*�ֹ���ȣ
	$UserName			= $_POST["ordername"] ;		//*�ֹ��ڸ�
	$IdNum				= $_POST["idnum"] ;			//�ֹι�ȣ or ����ڹ�ȣ
	$Email				= $_POST["email"] ;			//*email
	$GoodName			= $_POST["goodname"] ;		//*��ǰ��
	$PhoneNo			= $_POST["phoneno"] ;		//*�޴�����ȣ
//Header end -------------------------------------------------------------------

//Data Default-------------------------------------------------
	$ApprovalType		= $_POST["authty"] ;							//���α���
	$InterestType		= $_POST["interest"] ;							//�Ϲ�/�����ڱ��� 1:�Ϲ� 2:������
	// ī���ȣ=��ȿ�Ⱓ  or �ŷ���ȣ
	$TrackII			= $_POST["cardno"]."=".$_POST["expdt"];
	$Installment		= $_POST["installment"] ;						//�Һ�  00�Ͻú�
	$Amount				= $_POST["amount"] ;							//�ݾ�
	$Passwd				= $_POST["passwd"] ;							//��й�ȣ ��2�ڸ�
	$LastIdNum			= $_POST["lastidnum"] ;							//�ֹι�ȣ  ��7�ڸ�, ����ڹ�ȣ10
	$CurrencyType		= $_POST["currencytype"] ;						//��ȭ���� 0:��ȭ 1: ��ȭ

	$BatchUseType		= "0" ;											//�ŷ���ȣ��ġ��뱸��  0:�̻�� 1:���
	$CardSendType		= "0" ;											//ī�������������� 
	//0:������ 1:ī���ȣ,��ȿ�Ⱓ,�Һ�,�ݾ�,��������ȣ 2:ī���ȣ��14�ڸ� + "XXXX",��ȿ�Ⱓ,�Һ�,�ݾ�,��������ȣ
	$VisaAuthYn			= "7" ;											//������������ 0:������,7:SSL,9:��������
	$Domain				= "" ;											//������ ��ü������(PG��ü��)
	$IpAddr				= ${"REMOTE_ADDR"}; 							//IP ADDRESS ��ü������(PG��ü��)
	$BusinessNumber		= "" ;											//����� ��ȣ ��ü������(PG��ü��)
	$Filler				= "" ;											//����
	$AuthType			= "" ;											//ISP : ISP�ŷ�, MP1, MP2 : MPI�ŷ�, SPACE : �Ϲݰŷ�
	$MPIPositionType	= "" ;											//K : KSNET, R : Remote, C : ��3���, SPACE : �Ϲݰŷ�
	$MPIReUseType		= "" ;	      									//Y : ����, N : ����ƴ�
	$EncData			= "" ;											//MPI, ISP ������
	
	$cavv				= $_POST["cavv"] ;								//MPI��
	$xid				= $_POST["xid"] ;								//MPI��
	$eci				= $_POST["eci"]	 ;								//MPI��

	$KVP_PGID			= "" ;
	$KVP_CARDCODE		= "" ;
	$KVP_SESSIONKEY		= "" ;
	$KVP_ENCDATA		= "" ;

	/*ISP�ϰ��*/
	if($certitype == "I")
	{
		$TrackII		= "" ;
		$InterestType	= $_POST["KVP_NOINT"];							//�����ڱ���
		$Installment	= $_POST["KVP_QUOTA"];							//�Һ�:00�Ͻú�
		$KVP_PGID		= $_POST["KVP_PGID"];
		$KVP_CARDCODE	= $_POST["KVP_CARDCODE"];
		$KVP_SESSIONKEY	= $_POST["KVP_SESSIONKEY"];
		$KVP_ENCDATA	= $_POST["KVP_ENCDATA"];
	}
//Data Default end -------------------------------------------------------------

//Server�� ���� ������ ������ ��ü����
	$rApprovalType		= "1001" ; 
	$rTransactionNo		= "" ;											//�ŷ���ȣ
	$rStatus			= "X" ;											//���� O : ����, X : ����
	$rTradeDate			= "" ;											//�ŷ�����
	$rTradeTime			= "" ;											//�ŷ��ð�
	$rIssCode			= "00" ;										//�߱޻��ڵ�
	$rAquCode			= "00" ;										//���Ի��ڵ�
	$rAuthNo			= "9999" ;										//���ι�ȣ or ������ �����ڵ�
	$rMessage1			= "���ΰ���" ;									//�޽���1
	$rMessage2			= "C�������õ�" ;								//�޽���2
	$rCardNo			= "" ;											//ī���ȣ
	$rExpDate			= "" 	;										//��ȿ�Ⱓ
	$rInstallment		= "" ;											//�Һ�
	$rAmount			= "" ;											//�ݾ�
	$rMerchantNo		= "" ;											//��������ȣ
	$rAuthSendType		= "N" ;											//���۱���
	$rApprovalSendType	= "N" ;											//���۱���(0 : ����, 1 : ����, 2: ��ī��)
	$rPoint1			= "000000000000" ;								//Point1
	$rPoint2			= "000000000000" ;								//Point2
	$rPoint3			= "000000000000" ;								//Point3
	$rPoint4			= "000000000000" ;								//Point4
	$rVanTransactionNo	= "" ;
	$rFiller			= "" ;											//����
	$rAuthType	 		= "" ;											//ISP : ISP�ŷ�, MP1, MP2 : MPI�ŷ�, SPACE : �Ϲݰŷ�
	$rMPIPositionType	= "" ;											//K : KSNET, R : Remote, C : ��3���, SPACE : �Ϲݰŷ�
	$rMPIReUseType		= "" ;											//Y : ����, N : ����ƴ�
	$rEncData			= "" ;											//MPI, ISP ������
//--------------------------------------------------------------------------------

	/*������ �۽��Ұ��� ����(�߰赥���� IP/port) : ("210.181.28.137", 21001)*/
	KSPayApprovalCancel("210.181.28.137", 21001);

	/*��û��������(Header��)*/
	HeadMessage
	(
		$EncType,			// 0: ��ȭ����, 1:openssl, 2: seed       
		$Version,			// ��������                              
		$Type,				// ����                                  
		$Resend,			// ���۱��� : 0 : ó��,  2: ������    
		$RequestDate,		// ������
		$StoreId,			// �������̵�                                   
		$OrderNumber,		// �ֹ���ȣ                                     
		$UserName,			// �ֹ��ڸ�                                     
		$IdNum,				// �ֹι�ȣ or ����ڹ�ȣ                       
		$Email,				// email                                        
		$GoodType,			// ��ǰ���� 0 : �ǹ�, 1 : ������                
		$GoodName,			// ��ǰ��                                       
		$KeyInType,			// KeyInType ���� : S : Swap, K: KeyInType      
		$LineType,			// lineType 0 : offline, 1:internet, 2:Mobile   
		$PhoneNo,			// �޴�����ȣ                                   
		$ApprovalCount,		// ���ս��ΰ���                                 
		$HeadFiller			// ����                                         
	);

	/*������Ŀ� ���� ���������ͺ� ����*/
	//�Ϲݽ����ΰ��
	if($certitype == "A"||$certitype == "N")
	{
		$AuthType			= "" ;
		$MPIPositionType	= "" ;
		$MPIReUseType		= "" ;
		$EncData			= "" ;
	}
	//Visa3d���������ΰ��
	else if($certitype == "M")
	{
		$AuthType			= "M" ;
		$MPIPositionType	= "K" ;
		$MPIReUseType		= "N" ;
		$cavv				= format_string($cavv, 40, "Y");
		$xid				= format_string($xid,  40, "Y");
		$eci				= format_string($eci,   2, "Y");
		$EncData			= SetZero(strlen($cavv.$xid.$eci), 5).$cavv.$xid.$eci;
	}
	//ISP���������ΰ��
	else if($certitype == "I")
	{
		$AuthType			= "I";
		$MPIPositionType	= "K";
		$MPIReUseType		= "N";

		$KVP_SESSIONKEY		= urlencode($KVP_SESSIONKEY);
		$KVP_ENCDATA		= urlencode($KVP_ENCDATA);
		$KVP_SESSIONKEY		= SetZero(strlen($KVP_SESSIONKEY),4) . $KVP_SESSIONKEY;
		$KVP_ENCDATA		= SetZero(strlen($KVP_ENCDATA),4) . $KVP_ENCDATA;
		$KVP_CARDCODE		= SetZero(strlen($KVP_CARDCODE),2) . $KVP_CARDCODE;
		$KVP_CARDCODE		= format_string($KVP_CARDCODE, 22, "Y");
		$EncData					= SetZero(strlen($KVP_PGID.$KVP_SESSIONKEY.$KVP_ENCDATA.$KVP_CARDCODE),5).($KVP_PGID.$KVP_SESSIONKEY.$KVP_ENCDATA.$KVP_CARDCODE);

		if($InterestType == "0"||$InterestType == null)	$InterestType = "1" ;
		else	$InterestType = "2" ;
	}

	if($CurrencyType == "WON"||$CurrencyType == "410"||$CurrencyType== "")	$CurrencyType = "0" ;
	else if($CurrencyType == "USD"||$CurrencyType == "840")	$CurrencyType = "1" ;
	else	$CurrencyType = "0" ;

	/*��û��������(Data��)*/
	CreditDataMessage
	(
		$ApprovalType,		// ApprovalType	 : ���α���         
		$InterestType,		// InterestType    : �Ϲ�/�����ڱ��� 1:�Ϲ� 2:������                    
		$TrackII,			// TrackII		 : ī���ȣ=��ȿ�Ⱓ  or �ŷ���ȣ                            
		$Installment,		// Installment	 : �Һ�  00�Ͻú�                    
		$Amount,			// Amount		 : �ݾ�                            
		$Passwd,			// Passwd		 : ��й�ȣ ��2�ڸ�                               
		$LastIdNum,			// IdNum		 : �ֹι�ȣ  ��7�ڸ�, ����ڹ�ȣ10                      
		$CurrencyType,		// CurrencyType	 : ��ȭ���� 0:��ȭ 1: ��ȭ                    
		$BatchUseType,		// BatchUseType	 : �ŷ���ȣ��ġ��뱸��  0:�̻�� 1:���                      
		$CardSendType,		// CardSendType	 : ī���������� 0:������ 1:ī���ȣ,��ȿ�Ⱓ,�Һ�,�ݾ�,��������ȣ 2:ī���ȣ��14�ڸ� + "XXXX",��ȿ�Ⱓ,�Һ�,�ݾ�,��������ȣ    
		$VisaAuthYn,		// VisaAuthYn	 : ������������ 0:������,7:SSL,9:��������                         
		$Domain,			// Domain		 : ������ ��ü������(PG��ü��)                               
		$IpAddr,			// IpAddr		 : IP ADDRESS ��ü������(PG��ü��)                             
		$BusinessNumber,	// BusinessNumber: ����� ��ȣ ��ü������(PG��ü��)                       
		$Filler,			// Filler	     : ����                                         
		$AuthType,			// AuthType		 : ISP : ISP�ŷ�, MP1, MP2 : MPI�ŷ�, SPACE : �Ϲݰŷ�                              
		$MPIPositionType,	// MPIPositionType  : K : KSNET, R : Remote, C : ��3���, SPACE : �Ϲݰŷ�                      
		$MPIReUseType,		// MPIReUseType  : Y :  ����, N : ����ƴ�                           
		$EncData			// EndData       : MPI, ISP ������                                
	);

	/*�����ۼ���*/
	if (SendSocket("1")) 
	{
		$rApprovalType		= $ApprovalType;
		$rTransactionNo		= $TransactionNo;  			// �ŷ���ȣ
		$rStatus			= $Status;					// ���� O : ����, X : ����
		$rTradeDate			= $TradeDate;  				// �ŷ�����
		$rTradeTime			= $TradeTime;  				// �ŷ��ð�
		$rIssCode			= $IssCode;					// �߱޻��ڵ�
		$rAquCode			= $AquCode;					// ���Ի��ڵ�
		$rAuthNo			= $AuthNo;					// ���ι�ȣ or ������ �����ڵ�
		$rMessage1			= $Message1;				// �޽���1
		$rMessage2			= $Message2;				// �޽���2
		$rCardNo			= $CardNo;					// ī���ȣ
		$rExpDate			= $ExpDate;					// ��ȿ�Ⱓ
		$rInstallment		= $Installment;				// �Һ�
		$rAmount			= $Amount;					// �ݾ�
		$rMerchantNo		= $MerchantNo;				// ��������ȣ
		$rAuthSendType		= $AuthSendType;			// ���۱���= new String(this.read(2))
		$rApprovalSendType	= $ApprovalSendType;	 	// ���۱���(0 : ����, 1 : ����, 2: ��ī��)
		$rPoint1			= $Point1;					// Point1
		$rPoint2			= $Point2;					// Point2
		$rPoint3			= $Point3;					// Point3
		$rPoint4			= $Point4;					// Point4
		$rVanTransactionNo  = $VanTransactionNo;		// Van�ŷ���ȣ
		$rFiller			= $Filler;					// ����
		$rAuthType			= $AuthType;				// ISP : ISP�ŷ�, MP1, MP2 : MPI�ŷ�, SPACE : �Ϲݰŷ�
		$rMPIPositionType	= $MPIPositionType;			// K : KSNET, R : Remote, C : ��3���, SPACE : �Ϲݰŷ�
		$rMPIReUseType		= $MPIReUseType;			// Y : ����, N : ����ƴ�
		$rEncData			= $EncData;					// MPI, ISP ������
	}
?>

<html>
<head>
<title>KSPay</title>
<meta http-equiv="Content-Type" content="text/html charset=euc-kr">
<style type="text/css">
	TABLE{font-size:9pt; line-height:160%;}
	A {color:blueline-height:160% background-color:#E0EFFE}
	INPUT{font-size:9pt}
	SELECT{font-size:9pt}
	.emp{background-color:#FDEAFE}
	.white{background-color:#FFFFFF color:black border:1x solid white font-size: 9pt}
</style>
<script language="javascript">
<!--
document.onkeypress = processKey;
document.onkeydown  = processKey;

function processKey() {
        if(( event.ctrlKey == true && ( event.keyCode == 78 || event.keyCode == 82 ) ) ||
		( event.keyCode >= 112 && event.keyCode <= 123 ))
 	{
                event.keyCode = 0;
                event.cancelBubble = true;
                event.returnValue = false;
        }
        if(event.keyCode == 8 && typeof(event.srcElement.value) == "undefined") {
                event.keyCode = 0;
                event.cancelBubble = true;
                event.returnValue = false;
        }
}
-->
</script>
</head>

<body onload="" topmargin=0 leftmargin=0 marginwidth=0 marginheight=0 >
<table border=0 width=0>
<tr>
<td align=center>
<table width=320 cellspacing=0 cellpadding=0 border=0 bgcolor=#4F9AFF>
<tr>
<td>
<table width=100% cellspacing=1 cellpadding=2 border=0>
<tr bgcolor=#4F9AFF height=25>
<td align=left><font color="#FFFFFF">
KSPay �ſ�ī�� ���&nbsp;
<?
	if($certitype == "A")				echo("(�������½���)") ;
	else if($certitype == "N")		echo("(��������)") ;
	else if($certitype == "M")		echo("(M-Visa3D��������)") ;
	else if($certitype == "I")		echo("(I-ISP��������)") ;
?>
</font></td>
</tr>
<tr bgcolor=#FFFFFF>
<td valign=top>
<table width=100% cellspacing=0 cellpadding=2 border=0>
<tr>
<td align=left>
<table>
<tr>
	<td>�ŷ����� :</td>
	<td><?echo($rApprovalType)?></td>
</tr>
<tr>
	<td>�ŷ���ȣ :</td>
	<td><?echo($rTransactionNo)?></td>
</tr>
<tr>
	<td>�ŷ��������� :</td>
	<td><?echo($rStatus)?></td>
</tr>
<tr>
	<td>�ŷ��ð� :</td>
	<td><?echo($rTradeDate)?>&nbsp;<?echo($rTradeTime)?></td>
</tr>
<tr>
	<td>�߱޻��ڵ� :</td>
	<td><?echo($rIssCode)?></td>
</tr>
<tr>
	<td>���Ի��ڵ� :</td>
	<td><?echo($rAquCode)?></td>
</tr>
<tr>
	<td>���ι�ȣ :</td>
	<td><?echo($rAuthNo)?></td>
</tr>
<tr>
	<td>�޽���1 :</td>
	<td><?echo($rMessage1)?></td>
</tr>
<tr>
	<td>�޽���2 :</td>
	<td><?echo($rMessage2)?></td>
</tr>

</table>
</tr>
</table>
</td>
</tr>
</table>
</td>
</tr>
</table>
</td>
</tr>
</table>
</td>
</tr>
</table>
</table>
</body>
</html>