<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2011-08-19
* �ۼ���: ������
* ��   ��: ������û ù������
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
		$DOC_TITLE = "str:��û�ϱ�";
	}else{
		$DOC_TITLE = "str:��û�ϱ�(�����)";
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
	 * 1. �⺻�������� ����
	 *
	 * �����⺻������ �����Ͽ� �ֽñ� �ٶ��ϴ�.
	 */
	 if($test){
		$CST_PLATFORM	= "service";	// LG������ �������� ����(test:�׽�Ʈ, service:����)
	 }else{
		$CST_PLATFORM	= "service";	// LG������ �������� ����(test:�׽�Ʈ, service:����)
	 }
	
	if($data[str_study]=='y'){
		$CST_MID		= "studyhelper";// �������̵�(LG���������� ���� �߱޹����� �������̵� �Է��ϼ���)
	}else{
		$CST_MID		= "pafolschool";// �������̵�(LG���������� ���� �߱޹����� �������̵� �Է��ϼ���)
	}
	// �׽�Ʈ ���̵�� 't'�� �����ϰ� �Է��ϼ���.
	$LGD_MID	= (("test" == $CST_PLATFORM)?"t":"").$CST_MID;		// �������̵�(�ڵ�����)
	
	$LGD_OID	= $order_code;// �ֹ���ȣ
	 if($test){
		$LGD_AMOUNT		= 1000;	// �����ݾ�("," �� ������ �����ݾ��� �Է��ϼ���)
	 }else{
		$LGD_AMOUNT		= $data[num_price];	// �����ݾ�("," �� ������ �����ݾ��� �Է��ϼ���)
	 }
	$LGD_BUYER= $_SESSION[NAME];// �����ڸ�
	$LGD_PRODUCTINFO		= $data[str_title];// ��ǰ��
	$LGD_BUYEREMAIL= $data[str_email];// ������ �̸���
	
	$LGD_CASNOTEURL= "http://pafolschool.com/module/lms/noteurl.php";// ������� url
	
	$RESERVED= $RESERVED;		// Ÿ��
	$LGD_TIMESTAMP	= date("YmdHms");	// Ÿ�ӽ�����
    $LGD_CUSTOM_SKIN            = "red";                                //�������� ����â ��Ų (red, purple, yellow)
    $LGD_WINDOW_VER             = "2.5";                                //����â ��������

	//$LGD_CUSTOM_SKIN		= "";		// �������� ����â ��Ų (red, blue, cyan, green, yellow)
	//$LGD_CUSTOM_USABLEPAY		= "SC0010";	// Ư�� ������ܸ� ���̰��Ұ��(�ſ�ī��:SC0010 ��ȭ��ǰ��:SC0111)
	$LGD_CUSTOM_PROCESSTIMEOUT	= "600";// ������ ���ο�û���� ���� ��� �ð�(�ʴ���), ����Ʈ�� 10min


	//�Ʒ� �ʵ�� �ɼ��Դϴ�.
	if ($ssn_check=="Y")	 $LGD_BUYERSSN	= $Socialno3;		// ������û�� ����ڹ�ȣ
	else		$LGD_BUYERSSN	= $Socialno1.$Socialno2;// ������û�� �ֹε�Ϲ�ȣ

	$LGD_CHECKSSNYN		= "N";	// ������û�� �ֹε�� ��ȣ ��ġ ���� Ȯ�� �÷��� ( 'Y'�̸� ����â���� ���� �Է��� �ֹε�Ϲ�ȣ�� ��ġ���� Ȯ��)


	
	
	
	/*
	 *************************************************
	 * 2. MD5 �ؽ���ȣȭ (�������� ������) - BEGIN
	 * 
	 * MD5 �ؽ���ȣȭ�� �ŷ� �������� �������� ����Դϴ�. 
	 *************************************************
	 *
	 * �ؽ� ��ȣȭ ����( LGD_MID + Lmcrypt_ecbmcrypt_ecbGD_OID + LGD_AMOUNT + LGD_TIMESTAMP + LGD_MERTKEY )
	 * LGD_MID          : �������̵�
	 * LGD_OID          : �ֹ���ȣ
	 * LGD_AMOUNT       : �ݾ�
	 * LGD_TIMESTAMP    : Ÿ�ӽ�����
	 * LGD_MERTKEY      : ����MertKey (mertkey�� ���������� -> ������� -> ���������������� Ȯ���ϽǼ� �ֽ��ϴ�)
	 *
	 * MD5 �ؽ������� ��ȣȭ ������ ����
	 * LG�����޿��� �߱��� ����Ű(MertKey)�� ȯ�漳�� ����(lgdacom/conf/mall.conf)�� �ݵ�� �Է��Ͽ� �ֽñ� �ٶ��ϴ�.
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
	 * 2. MD5 �ؽ���ȣȭ (�������� ������) - END
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

    
	
//1)������� ȭ��ó��(����,���� ��� ó���� �Ͻñ� �ٶ��ϴ�.)
if ($xpay->TX())
{
		
		//����������û ��� ���� DBó��
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
		
		

		echo '<script>alert("��û�� �Ϸ�Ǿ����ϴ�.");</script>';
		echo "<meta http-equiv='Refresh' Content=\"0; URL='/member.mypage'\">";
		 
		}else{
				
				echo '<script>alert("���� �����Դϴ�. �����ڿ��� �������ֽñ� �ٶ��ϴ�..");</script>';
				echo "<meta http-equiv='Refresh' Content=\"0; URL='/main'\">";
		}


}else{
		echo '<script>alert("���� �����Դϴ�. �����ڿ��� �������ֽñ� �ٶ��ϴ�.");</script>';
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
		//7�� ������ ����~ 2013-09-03 ����
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
	
	echo '<script>alert("��û�� �Ϸ�Ǿ����ϴ�.");</script>';
	echo "<meta http-equiv='Refresh' Content=\"0; URL='/member.mypage'\">";

}
	
	
	

	 break;
	}

?>