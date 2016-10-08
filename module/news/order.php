<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2011-08-24
* 작성자: 김종태
* 설   명: 뉴스레터 
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');


switch ($REQUEST_METHOD) {
	case "GET":
	

		$tpl->setLayout('@sub');
		$tpl->define("CONTENT", Display::getTemplate("news/".$mode.".htm"));

	
	
	 break;
	case "POST":

	
		switch ($mode) {
		case "order":
		
		$datas[num_oid] = _OID;
		$datas[num_serial] = WebApp::maxSerial("TAB_NEWS_MEMBER","NUM_SERIAL");

		foreach( $_POST as $val => $value ){
			if(strstr($val,"num_") || strstr($val,"str_")){
				$datas[$val] = $value;
			}
		}
		
		if($DB->insertQuery("TAB_NEWS_MEMBER",$datas)){
			$DB->commit();
		}else{
			WebApp::moveBack('이미 등록되어있는 이메일 입니다.');
			exit;
		}
		
		
		WebApp::moveBack('정상적으로 신청되었습니다.');

		 break;

		 case "voll":
		
		
		
		for($ii=0; $ii<count($names); $ii++) {
			$human[$ii][num_oid] = _OID;
			$human[$ii][num_serial] = WebApp::maxSerial("TAB_NEWS_MEMBER","NUM_SERIAL");
			$human[$ii][str_name] = $_POST[names][$ii];
			$human[$ii][str_compay] =  $_POST[compays][$ii];
			$human[$ii][str_email] = $_POST[emails][$ii];
			$human[$ii][str_phone] = $_POST[phones][$ii];
			$human[$ii][str_voll] = $_POST[str_voll];
			$human[$ii][str_voll_email] = $_POST[str_voll_email];
			$human[$ii][str_root] = "추천인";
			
			

			if($human[$ii][str_name]){
				$iia +1;
				$DB->insertQuery("TAB_NEWS_MEMBER",$human[$ii]);
				$DB->commit();
			}
			
		}

		
		WebApp::moveBack('정상적으로 신청되었습니다.');

		 break;

		  case "nono":
		
		
		$datas[str_text] = $str_text;
		$datas[str_mailing] = 'n';
	
		
		if($DB->updateQuery("TAB_NEWS_MEMBER",$datas," str_name = '".$str_name."' and str_email = '".$str_email."' ")){

			WebApp::moveBack('정상적으로 해지되었습니다.');
		
		$DB->commit();
		}
		 break;
		
		
		}

		
	


	 break;
	}

?>