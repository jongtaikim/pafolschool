<?
//2008-01-04 ����
/**********************************
���ο� �б� ������

���α׷� : ���� 
������ : ��ȭ
**********************************/

if(_OID == 1) { //2008-01-21 ���� ���� Ȩ������

	echo "<meta http-equiv='Refresh' Content=\"0; URL='/bs.admin.main'\">";


}else{
	
$DB = &WebApp::singleton("DB");
$sql = "select str_end_date from tab_organ where num_oid = '$_OID' ";
$end_date = $DB -> sqlFetchOne($sql);

$sql2 = "select str_organ from tab_organ where num_oid = '$_OID' ";
$organ = $DB -> sqlFetchOne($sql2);



if($end_date) {
	
//echo date("Y-m-d" ,mktime()-86400)." < ".$end_date;


if(date("Y-m-d" ,mktime()-86400) < $end_date) {
	
	$tpl->setLayout('menu_no'); // ���̾ƿ��� ����
	$tpl->define("CONTENT", WebApp::getTemplate("admin2/main.htm"));
        $tpl->assign(array(
			'end_date'=>$end_date,
			'organ'=>$organ,
			));

}else{

echo '<script>alert("����Ʈ �������� �������ϴ�. �������� �����ϴ�.");</script>';
echo "<meta http-equiv='Refresh' Content=\"0; URL='/'\">";

}
}else{

	$tpl->setLayout('no'); // ���̾ƿ��� ����
	$tpl->define("CONTENT", WebApp::getTemplate("admin2/main.htm"));
        $tpl->assign(array(
			'organ'=>$organ
			));

}

}
?>

