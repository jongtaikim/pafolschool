
<?php

if(!$rurl) $rurl = $_SERVER[HTTP_HOST];
/*
 * [�������� ��û ������]
 *
 * �Ķ���� ���޽� POST�� ����ϼ���.
 */

    $CST_PLATFORM               = $HTTP_POST_VARS["CST_PLATFORM"];
    $CST_MID                    = $HTTP_POST_VARS["CST_MID"];
    $LGD_MID                    = (("test" == $CST_PLATFORM)?"t":"").$CST_MID;
    $LGD_PAYKEY                 = $HTTP_POST_VARS["LGD_PAYKEY"];

	require_once("/home/hosting_users/brainmapping/www/lgdacom/XPayClient.php");
	$configPath = "/home/hosting_users/brainmapping/www/lgdacom/"; 
	 $xpay = &new XPayClient($configPath, $CST_PLATFORM);
	$xpay->Init_TX($LGD_MID);    

	$xpay->Set("LGD_TXNAME", "PaymentByKey");
	$xpay->Set("LGD_PAYKEY", $LGD_PAYKEY);

  

  
	
//1)������� ȭ��ó��(����,���� ��� ó���� �Ͻñ� �ٶ��ϴ�.)
if ($xpay->TX())
{
	
	   $LGD_PAYTYPE =  $xpay->Response("LGD_PAYTYPE",0);
	   

			
		//����������û ��� ���� DBó��
		if( "0000" == $xpay->Response_Code() )
		{
		


	switch ($LGD_PAYTYPE) {
	case "SC0030": //������ü
		
		$datas[num_oid] = _OID;
		foreach( $_POST as $val => $value ){
			if(strstr($val,"num_") || strstr($val,"str_")){
				$datas[$val] = $value;
			}
		}



		$datas[str_order_code] = $xpay->Response("LGD_OID",0);
		$datas[str_email] = $email1."@".$email2;;
		$datas[str_pay_mes] = "bank";

		$datas[str_phone] = $tel1."-".$tel2."-".$tel3;
		$datas[str_handphone] = $tel11."-".$tel22."-".$tel33;
		$datas[str_st_email] =  $st_email1."@".$st_email2;
		$datas[dt_bank_date] = WebApp::mkday($_POST[dt_bank_date]);
		$datas[dt_date] = mktime();
		$datas[num_ccode] = $ccode;
		$datas[num_serial] = $serial;
		$datas[str_id] = $_SESSION[USERID];
		$datas[str_jumin] = $jumin1."-".$jumin2;

		$datas[str_order_st] = 1;
		
		if(date("Ymd") >= 20121101){
			if($str_etc < 4){
				if($str_etc == 1) $datas[str_discount] = 100000;
				if($str_etc == 2) $datas[str_discount] = 50000;
				if($str_etc == 3) $datas[str_discount] = 100000;
			}
		}

		//$sqlV ='y';
		
		
		$phoneno = $datas[str_handphone];
		$email = $$datas[str_email];
		
	
		$DB->insertQuery("TAB_ORDER",$datas);
		$DB->commit();
	

	
	
	 break;
	
	case "SC0040": //������ �Ա�
		
		$datas[num_oid] = _OID;
		foreach( $_POST as $val => $value ){
			if(strstr($val,"num_") || strstr($val,"str_")){
				$datas[$val] = $value;
			}
		}


		if($_POST[numberH] ==1){
			$datas[str_money_number] = $_POST[money_number1]."-".$_POST[money_number2]."-".$_POST[money_number3];
		}

		if($_POST[numberH] ==2){
			$datas[str_money_number] = $_POST[money_number11]."-".$_POST[money_number22];
		}
		if($_POST[numberH] ==3){
			$datas[str_money_number] = $_POST[money_number111]."-".$_POST[money_number222]."-".$_POST[money_number333];
		}


		$datas[str_order_code] = $xpay->Response("LGD_OID",0);
		$datas[str_email] = $email1."@".$email2;
		$datas[str_pay_mes] = "bank";

		$datas[str_phone] = $tel1."-".$tel2."-".$tel3;
		$datas[str_handphone] = $tel11."-".$tel22."-".$tel33;
		$datas[str_st_email] =  $st_email1."@".$st_email2;
		$datas[dt_bank_date] = WebApp::mkday($_POST[dt_bank_date]);
		$datas[dt_date] = mktime();
		$datas[num_ccode] = $ccode;
		$datas[num_serial] = $serial;
		$datas[str_id] = $_SESSION[USERID];
		$datas[str_jumin] = $jumin1."-".$jumin2;

		if($hold == 'y'){
			//7�� ������ ����~ 2013-09-03 ����
			$datas[str_order_st] = 7;
		}

		
		if(date("Ymd") >= 20121101){
			if($str_etc < 4){
				if($str_etc == 1) $datas[str_discount] = 100000;
				if($str_etc == 2) $datas[str_discount] = 50000;
				if($str_etc == 3) $datas[str_discount] = 100000;
			}
		}

		//$sqlV ='y';
		
		
		$phoneno = $datas[str_handphone];
		$email = $$datas[str_email];

		$DB->insertQuery("TAB_ORDER",$datas);
		$DB->commit();

	
	
	 break;
	case "SC0010": // �ſ�ī��

		$DB = &WebApp::singleton('DB');
		
		$datas[num_oid] = _OID;
			foreach( $_POST as $val => $value ){
				if(strstr($val,"num_") || strstr($val,"str_")){
					$datas[$val] = $value;
				}
			}
		if($hold == 'y'){
			//6�� ���� ����~ 2013-09-03 ����
			$datas[str_order_st] = 6;
		}else{
			$datas[str_order_st] = 5;
		}
		$datas[str_card_text] ="        
		TX Response_code = " . $xpay->Response_Code() ."<br>
		TX Response_msg = " . $xpay->Response_Msg() . "<br><br>

		�ŷ���ȣ : " . $xpay->Response("LGD_TID",0) . "<br>
		�������̵� : " . $xpay->Response("LGD_MID",0) . "<br>
		�����ֹ���ȣ : " . $xpay->Response("LGD_OID",0) . "<br>
		�����ݾ� : " . $xpay->Response("LGD_AMOUNT",0) . "<br>
		����ڵ� : " . $xpay->Response("LGD_RESPCODE",0) . "<br>
		����޼��� : " . $xpay->Response("LGD_RESPMSG",0) . "<br>

		";
		
		$datas[str_pay_mes] = "card";
		$datas[str_order_code] = $xpay->Response("LGD_OID",0);
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
		
		 //����������û ��� ���� DBó�� ���н� Rollback ó��
          	$isDBOK = true; //DBó�� ���н� false�� ������ �ּ���.
          	if( !$isDBOK ) {
           		echo "<p>";
           		$xpay->Rollback("���� DBó�� ���з� ���Ͽ� Rollback ó�� [TID:" . $xpay->Response("LGD_TID",0) . ",MID:" . $xpay->Response("LGD_MID",0) . ",OID:" . $xpay->Response("LGD_OID",0) . "]");            		            		
            		
                echo "TX Rollback Response_code = " . $xpay->Response_Code() . "<br>";
                echo "TX Rollback Response_msg = " . $xpay->Response_Msg() . "<p>";
            		
                if( "0000" == $xpay->Response_Code() ) {
                  	echo "�ڵ���Ұ� ���������� �Ϸ� �Ǿ����ϴ�.<br>";
                }else{
          			echo "�ڵ���Ұ� ���������� ó������ �ʾҽ��ϴ�.<br>";
                }
          	}        

	 break;
	}


	
		
	
		 echo '<script>alert("��û�� �Ϸ�Ǿ����ϴ�.");</script>';
		echo "<meta http-equiv='Refresh' Content=\"0; URL='/member.mypage'\">";


		}
		//����������û ��� ���� DBó��
		else
		{

		    
				
				
				echo '<script>alert("���������Դϴ�. �����ڿ��� �������ֽñ� �ٶ��ϴ�..");</script>';
				echo "<meta http-equiv='Refresh' Content=\"0; URL='/main'\">";
		}

}
//2)API ��û���� ȭ��ó��
else
{
		echo '<script>alert("���������Դϴ�. �����ڿ��� �������ֽñ� �ٶ��ϴ�.");</script>';
		echo "<meta http-equiv='Refresh' Content=\"0; URL='/main'\">";
}


?>
          