<?
//2008-01-04 종태
/**********************************
새로운 학교 관리자

프로그램 : 종태 
디자인 : 선화
**********************************/

if(_OID == 1) { //2008-01-21 종태 본사 홈페이지

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
	
	$tpl->setLayout('menu_no'); // 레이아웃은 서브
	$tpl->define("CONTENT", WebApp::getTemplate("admin2/main.htm"));
        $tpl->assign(array(
			'end_date'=>$end_date,
			'organ'=>$organ,
			));

}else{

echo '<script>alert("사이트 만료일이 지났습니다. 사용권한이 없습니다.");</script>';
echo "<meta http-equiv='Refresh' Content=\"0; URL='/'\">";

}
}else{

	$tpl->setLayout('no'); // 레이아웃은 서브
	$tpl->define("CONTENT", WebApp::getTemplate("admin2/main.htm"));
        $tpl->assign(array(
			'organ'=>$organ
			));

}

}
?>

