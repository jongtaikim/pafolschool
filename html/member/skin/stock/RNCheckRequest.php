<?php

	require_once( "./nice.nuguya.oivs.php" );

	//#######################################################################################
	//#####
	//#####	���νǸ�Ȯ�� ���� �ҽ� (�Ǹ�Ȯ�ο�û)						�ѱ��ſ�����(��)
	//#####	( PHPScript ó�� )
	//#####
	//#####	================================================================================
	//#####
	//#####	* �� �������� �ͻ��� ������ �����ؼ� �����Ͻʽÿ�.
	//#####	  �������� �����ϰų� �������� ���ʽÿ�. (���� ����� ������ �˴ϴ�)
	//#####
	//#######################################################################################

	/****************************************************************************************
	 *****	�� ȸ���� ID ���� : ���ÿ� �߱޵� ȸ���� ID�� �����Ͻʽÿ�. ��
	 ****************************************************************************************/

	$strNiceId = "Nnewstock";
	

	/****************************************************************************************
	 *****	��  NiceCheck.htm ���� �Ѱ� ���� SendInfo ���� ��ȣȭ �Ͽ� 
	 *****		�ֹι�ȣ,���� �� ������ ���� �����Ѵ� ��
	 ****************************************************************************************/
	$oivsObject->clientData = $_POST['SendInfo'];
	$oivsObject->desClientData();
	
	// ��ȣȭ �� ���� �Ʒ� �ּ��� Ǯ�� Ȯ�� �����մϴ�. 
	// (���� ȸ�� üũ�� �� �κп��� �Ͻø� �˴ϴ�.)
/*
	echo "<BR>���� : " . $oivsObject->userNm ;
	echo "<BR>�ֹι�ȣ/�ܱ��ι�ȣ : " . $oivsObject->resIdNo ;
	echo "<BR>��ȸ�����ڵ� : " . $oivsObject->inqRsn ;
	echo "<BR>��/�ܱ��� �����ڵ� : " . $oivsObject->foreigner ;
*/

	/****************************************************************************************
	 *****	�� �Ǹ�Ȯ�� ���񽺸� ȣ���Ѵ�. ��
	 ****************************************************************************************/

	$oivsObject->niceId = $strNiceId;
	$oivsObject->callService();

	/****************************************************************************************
	 *****	�� �Ǹ�Ȯ�� ���񽺸� ���䰪�� ó���Ѵ�. ��

	 *****	strRetCd �� strRetDtlCd�� �̿��Ͽ� �۾� �Ͻø� �˴ϴ�.
	 *****	��! strRetDtlCd �� Y,C�� ���� ������ ������ ���� �Ǹ�Ȯ���� ���Ƴ��� �����̹Ƿ� 
	 *****	���ý�ũ��Ʈ�� �������� ���ñ� �ٶ��ϴ�.
	 ****************************************************************************************/
	 
	//==================================================================================================================
	//				���信 ���� ��� �� �����鿡 ���� ����
	//------------------------------------------------------------------------------------------------------------------
	//
	//	< �ѱ��ſ����� �¶��� �ĺ� ���񽺿��� �����ϴ� ���� >
	//
	//	oivsObject->message			: ���� �Ǵ� ������ �޽���
	//	oivsObject->retCd			: ��� �ڵ�(�޴��� ����) // cf. �ѱ��ſ����� ���� ��� �� ���� ������ : https://www.nuguya.com
	//	oivsObject->retDtlCd			: ��� �� �ڵ�(�޴��� ����)
	//	oivsObject->minor 			: �������� ��� �ڵ�
	//									"1"	: ����
	//									"2"	: �̼���
	//									"9"	: Ȯ�� �Ұ�
	//
	//=================================================================================================================
?>

<html>
	<head>
		<title>�ѱ��ſ������ֽ�ȸ�� ���νǸ�Ȯ�� ���� ���� ������</Title>
		<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">

		<!--	==========================================================	-->
		<!--	�ѱ��ſ������ֽ�ȸ�� ó�� ��� (���� �� �������� ���ʽÿ�)	-->
		<!--	==========================================================	-->
		<script type="text/javascript" src="http://secure.nuguya.com/nuguya/nice.nuguya.oivs.crypto.js"></script>
		<script type="text/javascript" src="http://secure.nuguya.com/nuguya/nice.nuguya.oivs.msg.js"></script>
		<script type="text/javascript" src="http://secure.nuguya.com/nuguya/nice.nuguya.oivs.util.js"></script>
	</head>

	<script type="text/javascript">

		function loadAction()
		{
			var strRetCd = "<? echo $oivsObject->retCd; ?>";
			var strRetDtlCd = "<? echo $oivsObject->retDtlCd; ?>";
			var strMsg = "<? echo $oivsObject->message; ?>";

			//	�ѱ��ſ������� ���� ����ڵ忡 �ش��ϴ� �޽����� �޾ƿ´�.
			//	(�ٸ� �޽����� ������ �޴��� ������ �����Ͽ�  strRetCd, strRetDtlCd �� �޽����� ������ �ش�.
			strProcessMessage = getMessage( strRetCd, strRetDtlCd ); 


			if ( strRetCd == "1" ) // �Ǹ���������
			{
				alert( strProcessMessage ); //��� �޽��� ���
				parent.nameOk();
				parent.cchk();
			}
			else // �Ǹ���������
			{
			//	����� ���� �Ǹ�Ƚ����ܰ� ���ǵ��� ������ ó���Ѵ�.
				if ( strRetDtlCd == "Y" )
				{
					//	ó�� ����� �Ǹ�Ƚ����� ���������� Ȯ���Ѵ�.
					var retVal = confirm( strProcessMessage + "\n\n" + getCheckMessage( "S31" ) );
					if ( retVal == true )
					{
						history.go( -1 );
						goSafeBlockExpt();
						return;
					}
					else
					{
						history.go( -1 );
						return;
					}
				}
				else if ( strRetDtlCd == "C" )
				{
					//	ó�� ����� �Ǹ���ǵ������� ���������� Ȯ���Ѵ�.
					alert( strProcessMessage + "\n\n" + getCheckMessage( "S32" ) );
					document.getElementById( "Message" ).value = strProcessMessage;
				}
				else
				{
					
					alert( strProcessMessage ); //��� �޽��� ���
					

					
				}
			}
		}

	</script>


	<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onload="javascript:loadAction();" >
	</body>
   </html>