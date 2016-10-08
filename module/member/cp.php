<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-01-30
* 작성자: 김종태
* 설  명: 쿠폰 체크
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');

switch ($REQUEST_METHOD) {
	case "GET":
	
	$tpl->setLayout('admin');
	$tpl->define("CONTENT", Display::getTemplate("member/cp.htm"));
	
	 break;
	case "POST":
		$sql = "select str_use from TAB_BOOKCOUPON where str_coupon = '".$_POST['SRC_number']."'";
		$str_use = $DB -> sqlFetchOne($sql);

		if($str_use == 'N'){
			$sql = "UPDATE TAB_BOOKCOUPON SET 
							str_use='Y', str_id='".$_SESSION['USERID']."', str_date='".date("Ymd",mktime())."'
						WHERE str_coupon='".$_POST['SRC_number']."'";
			$DB->query($sql);
			$DB->commit();

			$sql = "UPDATE TAB_MEMBER SET num_point_total=num_point_total+50000 WHERE num_oid=$_OID and str_id='".$_SESSION['USERID']."'";
			$DB->query($sql);
			$DB->commit();	

			echo"업데이트 되었습니다.";

		}else if($str_use == 'Y'){
			WebApp::moveBack('입력하신 쿠폰번호는 이미 사용되었습니다.');

		}else{
			WebApp::moveBack('등록된 쿠폰이 없습니다.');

		}
		
	 break;
	}

?>