<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2009-08-10
* �ۼ���: ������
* ��   ��: �������ڵ� ����Ʈ
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');


switch ($REQUEST_METHOD) {
	case "GET":
	
	$sql = "select count(*) from TAB_VOTE_PEOPLE where num_oid = $_OID ";
	$total = $DB -> sqlFetchOne($sql);
	$tpl->assign(array('total'=>$total));
	
	

	 $sql = "SELECT * FROM(SELECT str_name,to_number(replace(replace(str_jumin,chr(13),''),'��','')) tmp_jumin, str_jumin,str_grade,str_class,to_number(replace(replace(str_class,chr(13),''),'��',''))  class2,str_code FROM TAB_VOTE_PEOPLE WHERE num_oid="._OID." ) ORDER BY str_grade,class2,tmp_jumin ";
	$data=$DB->sqlFetchAll($sql);
	$tpl->assign(array('LIST'=>$data));
	
	
	$tpl->setLayout('admin');
	$tpl->define("CONTENT", Display::getTemplate("vote/admin/print.htm"));
	
	 break;
	case "POST":
	 break;
	}

?>