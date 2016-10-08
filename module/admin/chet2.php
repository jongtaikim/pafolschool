<?
//2008-01-04 종태
/**********************************
새로운 학교 관리자 실시간 a/s

프로그램 : 종태 
디자인 : 선화
**********************************/

//$aaaip = explode(".",$_SERVER[REMOTE_ADDR]);




$tpl->setLayout('admin'); // 레이아웃은 서브
$tpl->define("CONTENT", WebApp::getTemplate("admin/chet2.htm"));

if(_OID == 1) { //2008-01-21 종태 본사 홈페이지

 $tpl->assign(array('organ'=>"본사운영자"));



}else{
	
$DB = &WebApp::singleton("DB");

$sql2 = "select str_organ from tab_organ where num_oid = '$_OID' ";
$organ = $DB -> sqlFetchOne($sql2);

        $tpl->assign(array('organ'=>$organ));





}


	

    if(check_edumark_ip()) {
       $tpl->assign(array('organ'=>"A/S관리자"));
    
	
	$DB = &WebApp::singleton("DB");


$sql = "select str_host,str_organ,num_oid from TAB_ORGAN order by num_oid desc ";
$row = $DB -> sqlFetchAll($sql);
$tpl->assign(array('LIST'=>$row,
	
'num_oid' => _OID));

	}

?>

