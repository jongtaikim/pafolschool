<?
/**
* ��ġ : html/member/join_chk1.html
* ���� : �̿��� �����
* ��¥ : 2007-06-20
* �ۼ��� : ������
*****************************************************************
* 
*/
$DOC_TITLE = 'str: ���۱ǽŰ�';

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
