<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2008-01-30
* �ۼ���: ������
* ��  ��: �����Ӹ�~!
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');


$sql = "select * from TAB_MAIN_VIS where num_oid = '"._OID."' and str_view = 'y'";
$row = $DB -> sqlFetchAll($sql);

$ia = 0;
for($ii=0; $ii<count($row); $ii++) {


	if(is_file(_DOC_ROOT."/hosts/".HOST."/vis/".$row[$ii][str_file])){
		$rows[$ia] = $row[$ii];
		$ia++;
	}
}


$tpl->assign(array('vis_LIST'=>$rows));


?>