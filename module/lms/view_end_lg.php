
<?php

if(!$rurl) $rurl = $_SERVER[HTTP_HOST];
/*
 * [결제승인 요청 페이지]
 *
 * 파라미터 전달시 POST를 사용하세요.
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

  

  
	
//1)결제결과 화면처리(성공,실패 결과 처리를 하시기 바랍니다.)
if ($xpay->TX())
{
	
	   $LGD_PAYTYPE =  $xpay->Response("LGD_PAYTYPE",0);
	   

			
		//최종결제요청 결과 성공 DB처리
		if( "0000" == $xpay->Response_Code() )
		{
		


	switch ($LGD_PAYTYPE) {
	case "SC0030": //계좌이체
		
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
	
	case "SC0040": //무통장 입금
		
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
			//7은 비결결제 대기닷~ 2013-09-03 종태
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
	case "SC0010": // 신용카드

		$DB = &WebApp::singleton('DB');
		
		$datas[num_oid] = _OID;
			foreach( $_POST as $val => $value ){
				if(strstr($val,"num_") || strstr($val,"str_")){
					$datas[$val] = $value;
				}
			}
		if($hold == 'y'){
			//6은 결제 대기닷~ 2013-09-03 종태
			$datas[str_order_st] = 6;
		}else{
			$datas[str_order_st] = 5;
		}
		$datas[str_card_text] ="        
		TX Response_code = " . $xpay->Response_Code() ."<br>
		TX Response_msg = " . $xpay->Response_Msg() . "<br><br>

		거래번호 : " . $xpay->Response("LGD_TID",0) . "<br>
		상점아이디 : " . $xpay->Response("LGD_MID",0) . "<br>
		상점주문번호 : " . $xpay->Response("LGD_OID",0) . "<br>
		결제금액 : " . $xpay->Response("LGD_AMOUNT",0) . "<br>
		결과코드 : " . $xpay->Response("LGD_RESPCODE",0) . "<br>
		결과메세지 : " . $xpay->Response("LGD_RESPMSG",0) . "<br>

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
		
		 //최종결제요청 결과 성공 DB처리 실패시 Rollback 처리
          	$isDBOK = true; //DB처리 실패시 false로 변경해 주세요.
          	if( !$isDBOK ) {
           		echo "<p>";
           		$xpay->Rollback("상점 DB처리 실패로 인하여 Rollback 처리 [TID:" . $xpay->Response("LGD_TID",0) . ",MID:" . $xpay->Response("LGD_MID",0) . ",OID:" . $xpay->Response("LGD_OID",0) . "]");            		            		
            		
                echo "TX Rollback Response_code = " . $xpay->Response_Code() . "<br>";
                echo "TX Rollback Response_msg = " . $xpay->Response_Msg() . "<p>";
            		
                if( "0000" == $xpay->Response_Code() ) {
                  	echo "자동취소가 정상적으로 완료 되었습니다.<br>";
                }else{
          			echo "자동취소가 정상적으로 처리되지 않았습니다.<br>";
                }
          	}        

	 break;
	}


	
		
	
		 echo '<script>alert("신청이 완료되었습니다.");</script>';
		echo "<meta http-equiv='Refresh' Content=\"0; URL='/member.mypage'\">";


		}
		//최종결제요청 결과 실패 DB처리
		else
		{

		    
				
				
				echo '<script>alert("결제오류입니다. 관리자에게 문의해주시기 바랍니다..");</script>';
				echo "<meta http-equiv='Refresh' Content=\"0; URL='/main'\">";
		}

}
//2)API 요청실패 화면처리
else
{
		echo '<script>alert("결제오류입니다. 관리자에게 문의해주시기 바랍니다.");</script>';
		echo "<meta http-equiv='Refresh' Content=\"0; URL='/main'\">";
}


?>
          