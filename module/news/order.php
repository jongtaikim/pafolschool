<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2011-08-24
* �ۼ���: ������
* ��   ��: �������� 
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
			WebApp::moveBack('�̹� ��ϵǾ��ִ� �̸��� �Դϴ�.');
			exit;
		}
		
		
		WebApp::moveBack('���������� ��û�Ǿ����ϴ�.');

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
			$human[$ii][str_root] = "��õ��";
			
			

			if($human[$ii][str_name]){
				$iia +1;
				$DB->insertQuery("TAB_NEWS_MEMBER",$human[$ii]);
				$DB->commit();
			}
			
		}

		
		WebApp::moveBack('���������� ��û�Ǿ����ϴ�.');

		 break;

		  case "nono":
		
		
		$datas[str_text] = $str_text;
		$datas[str_mailing] = 'n';
	
		
		if($DB->updateQuery("TAB_NEWS_MEMBER",$datas," str_name = '".$str_name."' and str_email = '".$str_email."' ")){

			WebApp::moveBack('���������� �����Ǿ����ϴ�.');
		
		$DB->commit();
		}
		 break;
		
		
		}

		
	


	 break;
	}

?>