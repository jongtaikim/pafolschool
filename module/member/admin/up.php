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


switch ($REQUEST_METHOD) {
	case "GET":
	

	$mtypes = WebApp::get('member',array('key'=>'member_types'));
	$sql = "select * from TAB_MEMBER_UP where num_oid = '$_OID' ";
	$row = $DB -> sqlFetchAll($sql);

for($ii=0; $ii<count($row); $ii++) {
	$row[$ii][mtypes] = $mtypes;
}


	$tpl->assign(array(            
		'MTYPES'        =>  $mtypes,
		'LIST'=>$row,
		));
	
	

	$tpl->setLayout('no3');
	$tpl->define("CONTENT", Display::getTemplate("member/admin/up.htm"));
	
	 break;
	case "POST":



$sql = "delete from TAB_MEMBER_UP where num_oid = '$_OID' ";
$DB->query($sql);
$DB->commit();

for($ii=0; $ii<count($str_up_mtype); $ii++) {
	

if($str_up_mtype[$ii] != "") {
	

$sql = "select max(num_serial)+1 from TAB_MEMBER_UP where num_oid = '$_OID'";
$max_num = $DB -> sqlFetchOne($sql);
if(!$max_num) $max_num= 1;

$sql = "INSERT INTO ".TAB_MEMBER_UP." 
	( 
   num_oid, 
   num_serial, 
   
  num_login_point, 
  num_board_point, 
  num_commint_point, 
  num_repaly_point, 
  num_join_point, 
  str_up_mtype
	
	) 
	VALUES 
	($_OID,
	'$max_num',
  '".$num_login_point[$ii]."', 
  '".$num_board_point[$ii]."', 
  '".$num_commint_point[$ii]."', 
  '".$num_repaly_point[$ii]."', 
  '".$num_join_point[$ii]."', 
  '".$str_up_mtype[$ii]."'

	) ";
	
	$DB->query($sql);
	$DB->commit();


}
}
WebApp::moveBack('설정되었습니다.');

	 break;
	}

?>