<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-01-30
* 작성자: 김종태
* 설  명: 몰라임마~!
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');
$content1 = file_get_contents(_DOC_ROOT.'/hosts/'.HOST.'/conf/member1.conf.php');
$content2 = file_get_contents(_DOC_ROOT.'/hosts/'.HOST.'/conf/member2.conf.php');
	
if(!$content1) {
	$content3 = file_get_contents(_DOC_ROOT.'/conf/member1.conf.php');
	$content1 = $content3;
}
$tpl->assign(array('content1'=>$content1,'content2'=>$content2,'content3'=>$content3));

switch ($REQUEST_METHOD) {
	case "GET":
	
	$tpl->setLayout('admin');
	$tpl->define("CONTENT", Display::getTemplate("member/join_c.htm"));
	
	 break;
	case "POST":
	
	$jumin =  $num_jumin1."-".$num_jumin2;


	$sql = "
	select  
	count(*)

	from  TAB_MEMBER  where num_jumin='$jumin'  and  num_oid = '"._OID."'";
	
	if($DB -> sqlFetchOne($sql)) {
	echo "<script>alert('이미 회원가입되어있는 사이트입니다.');</script>";
	 WebApp::closeWin();
	 exit;
	}

	$sql = "
	select  
	a.str_organ,
	a.num_oid,
	a.str_host,
	b.str_id,
	b.str_nick

	from TAB_ORGAN a, TAB_MEMBER b where   num_jumin = '$jumin'  and a.num_oid = b.num_oid and str_hometype = 'HOME'";
	$row = $DB -> sqlFetchAll($sql);
	
	if(!$row) {
	echo "<meta http-equiv='Refresh' Content=\"0; URL='member.join'\">";
	exit;	
	}else{
		for($ii=0; $ii<count($row); $ii++) {
			$row[$ii][str_id] = str_replace(substr($row[$ii][str_id],strlen($row[$ii][str_id]) -3, strlen($row[$ii][str_id]) ),"***",$row[$ii][str_id]);
		}
	
	}

	$sql = "
	select  
	count(*)

	from  TAB_ORGAN a, TAB_MEMBER b where   num_jumin = '$jumin'  and a.num_oid = b.num_oid and str_hometype = 'HOME' ";
	$total = $DB -> sqlFetchOne($sql);
	
	$tpl->assign(array(
		'LIST'=>$row,
		'TOTAL'=>$total,
		));

	$tpl->setLayout('admin');
	$tpl->define("CONTENT", Display::getTemplate("member/join_c.htm"));
	
	break;
	}

?>