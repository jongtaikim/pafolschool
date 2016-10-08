<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-12-26
* 작성자: 김종태
* 설   명: 슙하레이져 메뉴관리
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');


switch ($REQUEST_METHOD) {
	case "GET":
	
	$sql = "select * from TAB_PARTY_MENU where num_oid = $_OID and num_pcode = $pcode order by num_step asc";
	$menu = $DB -> sqlFetchAll($sql);

	$tpl->assign(array('LIST'=>$menu));
	
	

	$tpl->setLayout('admin');
	$tpl->define("CONTENT", Display::getTemplate("party/menu/admin/menutool.htm"));
	
	 break;
	case "POST":

if($mode=="auto") {
$using_components = str_replace('["',"",$using_components);
$using_components = str_replace('"]',"",$using_components);
$using_components = explode('","',$using_components);
//print_r($using_components);
}

for($ii=0; $ii<count($using_components); $ii++) {
$ma = explode("|",$using_components[$ii]);
$iia = $ii +1;
 if($ma[2]=="in") {
	$psql = ", str_in = 'Y'";
 }else{
    $psql = ", str_in = ''";
 }
 $sql = "UPDATE ".TAB_PARTY_MENU." SET str_type='".$ma[1]."' , num_step = '".$iia."'  $psql  WHERE num_oid=$_OID and num_pcode = $pcode and num_mcode = ".$ma[0]." ";
 $DB->query($sql);
 $DB->commit();
//echo $sql;
}

echo "<script>parent.submit_no_all()</script>";




break;
	}

?>