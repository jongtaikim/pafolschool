<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2009-08-10
* �ۼ���: ������
* ��   ��: �¶��� ��ǥ
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');


switch ($REQUEST_METHOD) {
	case "GET":
	
	$sql = "select * from TAB_VOTE where num_oid = $_OID order by dt_date asc ";
	$row = $DB -> sqlFetchAll($sql);
	$tpl->assign(array('LIST'=>$row));
	
	


	$tpl->setLayout('no3');
	$tpl->define("CONTENT", Display::getTemplate("vote/admin/main.htm"));
	
	 break;
	case "POST":
	 break;
	}

?>