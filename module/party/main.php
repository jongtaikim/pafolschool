<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: module/party/main.php
* �ۼ���: 2008-12-23
* �ۼ���: ������
* ��  ��: 
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');
$URL = &WebApp::singleton('WebAppURL');

//�����ڿ��� ������ �ֵ��� �̾ƿ���~
$sql = "select 
				a.num_mcode, a.str_title, a.str_skin
			from TAB_PARTY_BOARD_CONFIG a, TAB_PARTY_MENU b
			where 
				a.num_oid = $_OID 
				and a.num_pcode = $pcode 
				and a.str_main_view = 'Y'
				and a.num_oid=b.num_oid
				and a.num_pcode=b.num_pcode
				and a.num_mcode=b.num_mcode
			order by b.num_step";
$data = $DB->sqlFetchAll($sql);
$tpl->assign(array(
'BCLIST'=> $data,
));

$tpl->setLayout('p');
$tpl->define("CONTENT", Display::getTemplate("party/board/skin/".$board_skin."/main.htm"));


?>