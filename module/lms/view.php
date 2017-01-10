<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2011-08-19
* 작성자: 김종태
* 설   명: 교육신청 첫페이지
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');
$table = "TAB_CAMP";
$table2 = "TAB_LMS_CATE";

if($test){
	if(!$_SESSION[ADMIN]){
		exit;
	}
}

$order_code = $_SESSION[USERID]."_".date("YmdHis");
switch ($REQUEST_METHOD) {
	case "GET":
	
	
	if($hold != "y"){
		$DOC_TITLE = "str:신청하기";
	}else{
		$DOC_TITLE = "str:신청하기(대기자)";
	}

	$sql = "select * from TAB_MEMBER where num_oid = '$_OID' and str_id = '".$_SESSION[USERID]."' ";
	$data = $DB -> sqlFetch($sql);
	
	$tel = explode("-",$data[str_phone]);
	$data[tel1] = $tel[0];
	$data[tel2] = $tel[1];
	$data[tel3] = $tel[2];

	$tel = explode("-",$data[str_handphone]);
	$data[tel11] = $tel[0];
	$data[tel22] = $tel[1];
	$data[tel33] = $tel[2];

	$email = explode("@",$data[str_email]);
	$data[email1] = $email[0];
	$data[email2] = $email[1];

	$data[order_code] = $order_code;

	$data[dt_bank_date] = date("Y-m-d");
	$tpl->assign($data);
	



	$sql = "select * from $table where num_oid = '$_OID' and num_ccode = '$ccode' and num_serial = '".$serial."'";
	$data = $DB -> sqlFetch($sql);
	
	$sql = "select str_title from $table2 where num_oid = '$_OID' and num_ccode = '".$data[num_ccode]."' ";
	$data[str_title] = $DB -> sqlFetchOne($sql);
	
	$tpl->assign($data);
	
	
	

	$tpl->setLayout('@sub');
	if($test){
	$tpl->define("CONTENT", Display::getTemplate("lms/view_dev.htm"));
	}else{
	$tpl->define("CONTENT", Display::getTemplate("lms/view_dev.htm"));	
	}

	//

	//$tpl->define("CONTENT", Display::getTemplate("lms/view.htm"));

	/*
	 * 1. 기본인증정보 변경
	 *
	 * 인증기본정보를 변경하여 주시기 바랍니다.
	 */
	 if($test){
		$CST_PLATFORM	= "service";	// LG데이콤 인증서비스 선택(test:테스트, service:서비스)
	 }else{
		$CST_PLATFORM	= "service";	// LG데이콤 인증서비스 선택(test:테스트, service:서비스)
	 }
	
	if($data[str_study]=='y'){
		$CST_MID		= "studyhelper";// 상점아이디(LG데이콤으로 부터 발급받으신 상점아이디를 입력하세요)
	}else{
		$CST_MID		= "pafolschool";// 상점아이디(LG데이콤으로 부터 발급받으신 상점아이디를 입력하세요)
	}
	// 테스트 아이디는 't'를 제외하고 입력하세요.
	$LGD_MID	= (("test" == $CST_PLATFORM)?"t":"").$CST_MID;		// 상점아이디(자동생성)
	
	$LGD_OID	= $order_code;// 주문번호
	 if($test){
		$LGD_AMOUNT		= 1000;	// 결제금액("," 를 제외한 결제금액을 입력하세요)
	 }else{
		$LGD_AMOUNT		= $data[num_price];	// 결제금액("," 를 제외한 결제금액을 입력하세요)
	 }
	$LGD_BUYER= $_SESSION[NAME];// 구매자명
	$LGD_PRODUCTINFO		= $data[str_title];// 상품명
	$LGD_BUYEREMAIL= $data[str_email];// 구매자 이메일
	
	$LGD_CASNOTEURL= "http://pafolschool.com/module/lms/noteurl.php";// 무통장시 url
	
	$RESERVED= $RESERVED;		// 타입
	$LGD_TIMESTAMP	= date("YmdHms");	// 타임스탬프
    $LGD_CUSTOM_SKIN            = "red";                                //상점정의 결제창 스킨 (red, purple, yellow)
    $LGD_WINDOW_VER             = "2.5";                                //결제창 버젼정보

	//$LGD_CUSTOM_SKIN		= "";		// 상점정의 결제창 스킨 (red, blue, cyan, green, yellow)
	//$LGD_CUSTOM_USABLEPAY		= "SC0010";	// 특정 결재수단만 보이게할경우(신용카드:SC0010 문화상품권:SC0111)
	$LGD_CUSTOM_PROCESSTIMEOUT	= "600";// 인증후 승인요청까지 가능 허용 시간(초단위), 디폴트는 10min


	//아래 필드는 옵션입니다.
	if ($ssn_check=="Y")	 $LGD_BUYERSSN	= $Socialno3;		// 인증요청자 사업자번호
	else		$LGD_BUYERSSN	= $Socialno1.$Socialno2;// 인증요청자 주민등록번호

	$LGD_CHECKSSNYN		= "N";	// 인증요청자 주민등록 번호 일치 여부 확인 플래그 ( 'Y'이면 인증창에서 고객이 입력한 주민등록번호와 일치여부 확인)


	
	
	
	/*
	 *************************************************
	 * 2. MD5 해쉬암호화 (수정하지 마세요) - BEGIN
	 * 
	 * MD5 해쉬암호화는 거래 위변조를 막기위한 방법입니다. 
	 *************************************************
	 *
	 * 해쉬 암호화 적용( LGD_MID + Lmcrypt_ecbmcrypt_ecbGD_OID + LGD_AMOUNT + LGD_TIMESTAMP + LGD_MERTKEY )
	 * LGD_MID          : 상점아이디
	 * LGD_OID          : 주문번호
	 * LGD_AMOUNT       : 금액
	 * LGD_TIMESTAMP    : 타임스탬프
	 * LGD_MERTKEY      : 상점MertKey (mertkey는 상점관리자 -> 계약정보 -> 상점정보관리에서 확인하실수 있습니다)
	 *
	 * MD5 해쉬데이터 암호화 검증을 위해
	 * LG데이콤에서 발급한 상점키(MertKey)를 환경설정 파일(lgdacom/conf/mall.conf)에 반드시 입력하여 주시기 바랍니다.
	 */
	//require_once("./lgdacom/XPayClient.php");
	require_once("/home/hosting_users/brainmapping/www/lgdacom/XPayClient.php");
	$configPath = "/home/hosting_users/brainmapping/www/lgdacom/"; 	
	$xpay = new XPayClient($configPath, $LGD_PLATFORM);
	
	$xpay->Init_TX($LGD_MID);
	$LGD_HASHDATA = md5($LGD_MID.$LGD_OID.$LGD_AMOUNT.$LGD_TIMESTAMP.$xpay->config[$LGD_MID]);
	 $LGD_CUSTOM_PROCESSTYPE = "TWOTR";
	/*
	 *************************************************
	 * 2. MD5 해쉬암호화 (수정하지 마세요) - END
	 *************************************************
	 */


		$tpl->assign(array(
		'CST_PLATFORM'=>$CST_PLATFORM,
		'CST_MID'=>$CST_MID,
		'LGD_MID'=>$LGD_MID,
		'LGD_OID'=>$LGD_OID,
		'LGD_AMOUNT'=>$LGD_AMOUNT,
		'LGD_BUYER'=>$LGD_BUYER,
		'LGD_PRODUCTINFO'=>$LGD_PRODUCTINFO,
		'LGD_BUYEREMAIL'=>$LGD_BUYEREMAIL,
		'RESERVED'=>$RESERVED,
		'LGD_TIMESTAMP'=>$LGD_TIMESTAMP,
		'LGD_CUSTOM_USABLEPAY'=>$LGD_CUSTOM_USABLEPAY,
		'LGD_CUSTOM_PROCESSTIMEOUT'=>$LGD_CUSTOM_PROCESSTIMEOUT,
		'LGD_BUYERSSN'=>$LGD_BUYERSSN,
		'LGD_CHECKSSNYN'=>$LGD_CHECKSSNYN,
		'LGD_HASHDATA'=>$LGD_HASHDATA,
		'LGD_CUSTOM_PROCESSTYPE'=>$LGD_CUSTOM_PROCESSTYPE,
		'LGD_CASNOTEURL'=>$LGD_CASNOTEURL,
		'LGD_WINDOW_VER'=>$LGD_WINDOW_VER,
		'LGD_CUSTOM_SKIN'=>$LGD_CUSTOM_SKIN,
		'real_money'=>$real_money,

	));

	
	
	
	 break;
	case "POST":

if($str_pay_mes == "card"){
	
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
		
		//최종결제요청 결과 성공 DB처리
		if( "0000" == $xpay->Response_Code() )
		{

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


		$datas[str_order_code] = $order_code;
		$datas[str_email] = $email1."@".$email2;;

		$datas[str_phone] = $tel1."-".$tel2."-".$tel3;
		$datas[str_handphone] = $tel11."-".$tel22."-".$tel33;
		$datas[str_st_email] =  $st_email1."@".$st_email2;
		$datas[dt_bank_date] = WebApp::mkday($_POST[dt_bank_date]);
		$datas[dt_date] = mktime();
		$datas[num_ccode] = $ccode;
		$datas[num_serial] = $serial;
		$datas[str_id] = $_SESSION[USERID];
		$datas[str_jumin] = $jumin1."-".$jumin2;

		if($_GET[hold] == 'y'){
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
		
		

		echo '<script>alert("신청이 완료되었습니다.");</script>';
		echo "<meta http-equiv='Refresh' Content=\"0; URL='/member.mypage'\">";
		 
		}else{
				
				echo '<script>alert("결제 오류입니다. 관리자에게 문의해주시기 바랍니다..");</script>';
				echo "<meta http-equiv='Refresh' Content=\"0; URL='/main'\">";
		}


}else{
		echo '<script>alert("결제 오류입니다. 관리자에게 문의해주시기 바랍니다.");</script>';
		echo "<meta http-equiv='Refresh' Content=\"0; URL='/main'\">";
}



}else{

 
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

	$datas[str_order_code] = $order_code;
	$datas[str_email] = $email1."@".$email2;;

	$datas[str_phone] = $tel1."-".$tel2."-".$tel3;
	$datas[str_handphone] = $tel11."-".$tel22."-".$tel33;
	$datas[str_st_email] =  $st_email1."@".$st_email2;
	$datas[dt_bank_date] = WebApp::mkday($_POST[dt_bank_date]);
	$datas[dt_date] = mktime();
	$datas[num_ccode] = $ccode;
	$datas[num_serial] = $serial;
	$datas[str_id] = $_SESSION[USERID];
	$datas[str_jumin] = $jumin1."-".$jumin2;

	if($_GET[hold] == 'y'){
		//7은 비결결제 대기닷~ 2013-09-03 종태
		$datas[str_order_st] = 7;
	}

	
	if(date("Ymd") >= 20131112){
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
	
	echo '<script>alert("신청이 완료되었습니다.");</script>';
	echo "<meta http-equiv='Refresh' Content=\"0; URL='/member.mypage'\">";

}
	
	
	

	 break;
	}

?>