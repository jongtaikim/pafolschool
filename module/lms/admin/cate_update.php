<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2010-12-07
* �ۼ���: ������
* ��   ��: ��������
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');


switch ($REQUEST_METHOD) {
	case "GET":
	
	//2010-12-08 ���� ī�װ�
	$sql = "select * from ".$table2." where num_oid = '$_OID' order by num_step";
	$cate_list = $DB -> sqlFetchAll($sql);
	$tpl->assign(array('cate_LIST'=>$cate_list));

	$tpl->setLayout('ajax');
	$tpl->define("CONTENT", Display::getTemplate("admin/lms/cate_update.htm"));
	
	 break;
	case "POST":
	 break;
	}

?>