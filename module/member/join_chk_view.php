<?
/**
* ��ġ : html/member/join_chk1.html
* ���� : �̿��� �����
* ��¥ : 2007-06-20
* �ۼ��� : ������
*****************************************************************
* 
*/
		

		$DB = &WebApp::singleton('DB');
		$sql2 = "SELECT * FROM ".TAB_ORGAN." WHERE NUM_OID=$_OID";
		$data2 = $DB->sqlFetch($sql2);
		$DOC_TITLE = 'str: ��������ȣ��å';
		$tpl->setLayout('@sub');
		$tpl->define('CONTENT',Display::getTemplate('member/join_chk1.html'));
		$tpl->assign(array(
			"str_organ"                 => $data2[str_organ],
			"chr_zip"                    => $data2[chr_zip],
			"str_addr1"                 => $data2[str_addr1],
			"str_addr2"                 => $data2[str_addr2],
		));


			


?>
