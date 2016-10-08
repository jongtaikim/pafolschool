
<?php

if(!$rurl) $rurl = $_SERVER[HTTP_HOST];
/*
 * [결제승인 요청 페이지]
 *
 * 파라미터 전달시 POST를 사용하세요.
 */




$CST_PLATFORM			= $_POST["CST_PLATFORM"];       		//LG데이콤 결제 서비스 선택(test:테스트, service:서비스)
$CST_MID							= $_POST["CST_MID"];            				//상점아이디(LG데이콤으로 부터 발급받으신 상점아이디를 입력하세요)
//테스트 아이디는 't'를 반드시 제외하고 입력하세요.

$LGD_MID						= (("test" == $CST_PLATFORM)?"t":"").$CST_MID;  //상점아이디(자동생성)
//$LGD_MID	= $CST_MID;

$LGD_OID                		= $_POST["LGD_OID"];							//주문번호(상점정의 유니크한 주문번호를 입력하세요)
$LGD_AMOUNT				= $_POST["LGD_AMOUNT"];			 		//결제금액("," 를 제외한 결제금액을 입력하세요)
$LGD_PAN						= $_POST["LGD_BILLKEY"];	 				//빌링키

$LGD_INSTALL               = "00";	 																				//할부개월수

$LGD_EXPYEAR	            = $_POST["LGD_EXPYEAR"]; 				//유효기간년
$LGD_EXPMON	            = $_POST["LGD_EXPMON"];		 			//유효기간월 
$LGD_PIN                			= $_POST["LGD_PIN"];	 						//비밀번호 앞2자리(옵션-주민번호를 넘기지 않으면 비밀번호도 체크 안함)
$LGD_PRIVATENO	        = $_POST["LGD_PRIVATENO"]; 			//주민번호 뒷7자리 또는 사업자번호 10자리(옵션)

$LGD_BUYERPHONE	= $_POST["LGD_BUYERPHONE"];		//고객 휴대폰번호(SMS발송:선택)

$LGD_BUYERSSN			= $_POST["LGD_BUYERSSN"];			//주민등록번호
$LGD_BUYER					= $_POST["LGD_BUYER"];						//구매자
$LGD_PRODUCTINFO	= $_POST["LGD_PRODUCTINFO"];		// 상품명
$LGD_BUYEREMAIL		= $_POST["LGD_BUYEREMAIL"];			// 구매자 이메일

$VBV_ECI							= "010";		 																		//결제방식(KeyIn:010, Swipe:020)

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
    
	
if ($VBV_ECI == "010") //키인방식인 경우에만 해당
{    	 			
		$xpay->Set("LGD_EXPYEAR", $LGD_EXPYEAR);
		$xpay->Set("LGD_EXPMON", $LGD_EXPMON);
		$xpay->Set("LGD_PIN", $LGD_PIN);
		$xpay->Set("LGD_PRIVATENO", $LGD_PRIVATENO);
}
  
    
	
//1)결제결과 화면처리(성공,실패 결과 처리를 하시기 바랍니다.)
if ($xpay->TX())
{
		
		//최종결제요청 결과 성공 DB처리
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
			//6은 결제 대기닷~ 2013-09-03 종태
			$datas[str_order_st] = 6;
		}else{
			$datas[str_order_st] = 5;
		}
		$datas[str_card_text] ="
		응답코드 : ".$xpay->Response_Code()."<br>
		
		금액 : ".$LGD_AMOUNT."<br>
		
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
	
		 echo '<script>alert("신청이 완료되었습니다.");</script>';
		echo "<meta http-equiv='Refresh' Content=\"0; URL='/member.mypage'\">";


		}
		//최종결제요청 결과 실패 DB처리
		else
		{
				echo '<script>alert("카드승인 오류입니다. 관리자에게 문의해주시기 바랍니다.");</script>';
				echo "<meta http-equiv='Refresh' Content=\"0; URL='/main'\">";
		}

}
//2)API 요청실패 화면처리
else
{
		echo '<script>alert("카드승인 오류입니다. 관리자에게 문의해주시기 바랍니다.");</script>';
		echo "<meta http-equiv='Refresh' Content=\"0; URL='/main'\">";
}


?>
          