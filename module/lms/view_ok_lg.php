
<?php

if(!$rurl) $rurl = $_SERVER[HTTP_HOST];
/*
 * [�������� ��û ������]
 *
 * �Ķ���� ���޽� POST�� ����ϼ���.
 */




$CST_PLATFORM			= $_POST["CST_PLATFORM"];       		//LG������ ���� ���� ����(test:�׽�Ʈ, service:����)
$CST_MID							= $_POST["CST_MID"];            				//�������̵�(LG���������� ���� �߱޹����� �������̵� �Է��ϼ���)
//�׽�Ʈ ���̵�� 't'�� �ݵ�� �����ϰ� �Է��ϼ���.

$LGD_MID						= (("test" == $CST_PLATFORM)?"t":"").$CST_MID;  //�������̵�(�ڵ�����)
//$LGD_MID	= $CST_MID;

$LGD_OID                		= $_POST["LGD_OID"];							//�ֹ���ȣ(�������� ����ũ�� �ֹ���ȣ�� �Է��ϼ���)
$LGD_AMOUNT				= $_POST["LGD_AMOUNT"];			 		//�����ݾ�("," �� ������ �����ݾ��� �Է��ϼ���)
$LGD_PAN						= $_POST["LGD_BILLKEY"];	 				//����Ű

$LGD_INSTALL               = "00";	 																				//�Һΰ�����

$LGD_EXPYEAR	            = $_POST["LGD_EXPYEAR"]; 				//��ȿ�Ⱓ��
$LGD_EXPMON	            = $_POST["LGD_EXPMON"];		 			//��ȿ�Ⱓ�� 
$LGD_PIN                			= $_POST["LGD_PIN"];	 						//��й�ȣ ��2�ڸ�(�ɼ�-�ֹι�ȣ�� �ѱ��� ������ ��й�ȣ�� üũ ����)
$LGD_PRIVATENO	        = $_POST["LGD_PRIVATENO"]; 			//�ֹι�ȣ ��7�ڸ� �Ǵ� ����ڹ�ȣ 10�ڸ�(�ɼ�)

$LGD_BUYERPHONE	= $_POST["LGD_BUYERPHONE"];		//�� �޴�����ȣ(SMS�߼�:����)

$LGD_BUYERSSN			= $_POST["LGD_BUYERSSN"];			//�ֹε�Ϲ�ȣ
$LGD_BUYER					= $_POST["LGD_BUYER"];						//������
$LGD_PRODUCTINFO	= $_POST["LGD_PRODUCTINFO"];		// ��ǰ��
$LGD_BUYEREMAIL		= $_POST["LGD_BUYEREMAIL"];			// ������ �̸���

$VBV_ECI							= "010";		 																		//�������(KeyIn:010, Swipe:020)

require_once("/home/hosting_users/brainmapping/www/lgdacom/XPayClient.php");
$configPath = "/home/hosting_users/brainmapping/www/lgdacom/"; 
$xpay = new XPayClient($configPath, $CST_PLATFORM);
//$xpay = &$xpay;
$xpay->Init_TX($LGD_MID);

$xpay->Set("LGD_TXNAME", "CardAuth");
$xpay->Set("LGD_OID", $LGD_OID);
$xpay->Set("LGD_AMOUNT", $LGD_AMOUNT);
$xpay->Set("LGD_PAN", $LGD_PAN);
$xpay->Set("LGD_INSTALL", $LGD_INSTALL);
$xpay->Set("LGD_BUYERPHONE", $LGD_BUYERPHONE);
$xpay->Set("VBV_ECI", $VBV_ECI);
$xpay->Set("LGD_BUYER", $LGD_BUYER);
$xpay->Set("LGD_PRODUCTINFO", $LGD_PRODUCTINFO);
$xpay->Set("LGD_BUYEREMAIL", $LGD_BUYEREMAIL);
$xpay->Set("LGD_BUYERSSN", $LGD_BUYERSSN);
    
	
if ($VBV_ECI == "010") //Ű�ι���� ��쿡�� �ش�
{    	 			
		$xpay->Set("LGD_EXPYEAR", $LGD_EXPYEAR);
		$xpay->Set("LGD_EXPMON", $LGD_EXPMON);
		$xpay->Set("LGD_PIN", $LGD_PIN);
		$xpay->Set("LGD_PRIVATENO", $LGD_PRIVATENO);
}
  
    
	
//1)������� ȭ��ó��(����,���� ��� ó���� �Ͻñ� �ٶ��ϴ�.)
if ($xpay->TX())
{
		
		//����������û ��� ���� DBó��
		if( "0000" == $xpay->Response_Code() )
		{
				
		$DB = &WebApp::singleton('DB');

		$datas[num_oid] = _OID;
			foreach( $_POST as $val => $value ){
				if(strstr($val,"num_") || strstr($val,"str_")){
					$datas[$val] = $value;
				}
			}
		if($_GET[hold] == 'y'){
			//6�� ���� ����~ 2013-09-03 ����
			$datas[str_order_st] = 6;
		}else{
			$datas[str_order_st] = 5;
		}
		$datas[str_card_text] ="
		�����ڵ� : ".$xpay->Response_Code()."<br>
		
		�ݾ� : ".$LGD_AMOUNT."<br>
		
		";
		

		$datas[str_order_code] = $ordno;
		$datas[str_email] = $email1."@".$email2;;

		$datas[str_phone] = $tel1."-".$tel2."-".$tel3;
		$datas[str_handphone] = $tel11."-".$tel22."-".$tel33;
		$datas[str_st_email] =  $st_email1."@".$st_email2;
		
		$datas[dt_date] = mktime();
		$datas[num_ccode] = $ccode;
		$datas[num_serial] = $serial;
		$datas[str_id] = $_SESSION[USERID];
		$datas[str_jumin] = $jumin1."-".$jumin2;
		

		if(date("Ymd") >= 20121101){
			if($str_etc < 4){
				if($str_etc == 1) $datas[str_discount] = 100000;
				if($str_etc == 2) $datas[str_discount] = 50000;
				if($str_etc == 3) $datas[str_discount] = 100000;
			}
		}
		
		//$sqlV ='y';
		
		$DB->insertQuery("TAB_ORDER",$datas);
		$DB->commit();
	
		 echo '<script>alert("��û�� �Ϸ�Ǿ����ϴ�.");</script>';
		echo "<meta http-equiv='Refresh' Content=\"0; URL='/member.mypage'\">";


		}
		//����������û ��� ���� DBó��
		else
		{
				echo '<script>alert("ī����� �����Դϴ�. �����ڿ��� �������ֽñ� �ٶ��ϴ�.");</script>';
				echo "<meta http-equiv='Refresh' Content=\"0; URL='/main'\">";
		}

}
//2)API ��û���� ȭ��ó��
else
{
		echo '<script>alert("ī����� �����Դϴ�. �����ڿ��� �������ֽñ� �ٶ��ϴ�.");</script>';
		echo "<meta http-equiv='Refresh' Content=\"0; URL='/main'\">";
}


?>
          