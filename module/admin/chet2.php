<?
//2008-01-04 ����
/**********************************
���ο� �б� ������ �ǽð� a/s

���α׷� : ���� 
������ : ��ȭ
**********************************/

//$aaaip = explode(".",$_SERVER[REMOTE_ADDR]);




$tpl->setLayout('admin'); // ���̾ƿ��� ����
$tpl->define("CONTENT", WebApp::getTemplate("admin/chet2.htm"));

if(_OID == 1) { //2008-01-21 ���� ���� Ȩ������

 $tpl->assign(array('organ'=>"������"));



}else{
	
$DB = &WebApp::singleton("DB");

$sql2 = "select str_organ from tab_organ where num_oid = '$_OID' ";
$organ = $DB -> sqlFetchOne($sql2);

        $tpl->assign(array('organ'=>$organ));





}


	

    if(check_edumark_ip()) {
       $tpl->assign(array('organ'=>"A/S������"));
    
	
	$DB = &WebApp::singleton("DB");


$sql = "select str_host,str_organ,num_oid from TAB_ORGAN order by num_oid desc ";
$row = $DB -> sqlFetchAll($sql);
$tpl->assign(array('LIST'=>$row,
	
'num_oid' => _OID));

	}

?>

