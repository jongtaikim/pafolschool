<?
/**
* 위치 : html/member/join_chk1.html
* 제목 : 이용약관 만들기
* 날짜 : 2007-06-20
* 작성자 : 김종태
*****************************************************************
* 
*/
		

		$DB = &WebApp::singleton('DB');
		$sql2 = "SELECT * FROM ".TAB_ORGAN." WHERE NUM_OID=$_OID";
		$data2 = $DB->sqlFetch($sql2);
		$DOC_TITLE = 'str: 개인정보호정책';
		$tpl->setLayout('@sub');
		$tpl->define('CONTENT',Display::getTemplate('member/join_chk1.html'));
		$tpl->assign(array(
			"str_organ"                 => $data2[str_organ],
			"chr_zip"                    => $data2[chr_zip],
			"str_addr1"                 => $data2[str_addr1],
			"str_addr2"                 => $data2[str_addr2],
		));


			


?>
