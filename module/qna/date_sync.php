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

$sql = "select * from TAB_QNA ";
$row = $DB -> sqlFetchAll($sql);

for($ii=0; $ii<count($row); $ii++) {

 $datas[$ii][str_date] = WebApp::mkday(substr($row[$ii][str_date],0,10));

 echo date("Y-m-d",$datas[$ii][str_date])."<br>";

 $DB->updateQuery("TAB_QNA",$datas[$ii]," num_serial = '".$row[$ii][num_serial]."'");
 $DB->commit();
	
}




?>