<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2009-08-10
* �ۼ���: ������
* ��  ��:  ��ǥ����
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');


switch ($REQUEST_METHOD) {
	case "GET":
	
	$sql = "select * from TAB_VOTE where num_oid = $_OID and num_start_date <= ".mktime()." and num_end_date >= ".mktime()."";
	$row = $DB -> sqlFetchAll($sql);
	$tpl->assign(array('LIST'=>$row));
	
	
	
	$tpl->setLayout('admin_xhtml');
	if(count($row) >0){
	$tpl->define("CONTENT", Display::getTemplate("vote/view.htm"));
	}else{
	$tpl->define("CONTENT", Display::getTemplate("vote/no.htm"));
	}
	 break;
	case "POST":
	 break;
	}

?>