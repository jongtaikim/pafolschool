<?
/**
* 위치 : html/member/join_chk1.html
* 제목 : 이용약관 만들기
* 날짜 : 2007-06-20
* 작성자 : 김종태
*****************************************************************
* 
*/
$DOC_TITLE = 'str: 저작권신고';

$DB = &WebApp::singleton('DB');
$sql = "SELECT 
			*

  FROM TAB_ORGAN WHERE NUM_OID=$_OID";



$data_mem = $DB->sqlFetch($sql);


		$tpl->setLayout('@sub');
	
		$tpl->define('CONTENT',Display::getTemplate('singo/singo.htm'));

		$tpl->assign(array(
			'name' => $data_mem['str_master_name'],
			'phone' => $data_mem['str_master_phone'],
			'fax' => $data_mem['str_fax'],
			'email' => $data_mem['str_master_email'],
			'addr1' => $data_mem['str_addr1'],
			'addr2' => $data_mem['str_addr2'],


		));

?>
