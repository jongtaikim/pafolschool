<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-09-30
* 작성자: 김종태
* 설  명:  입력폼에 받은 데이터 확인
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');
//==-- Functions --==//
function cut_str($str,$len,$tail="..") {
	if(strlen($str) > $len) {
		for($i=0; $i<$len; $i++) if(ord($str[$i])>127) $i++;
		$str=substr($str,0,$i).$tail;
	}
	return $str;
}


switch ($REQUEST_METHOD) {
	case "GET":
	
if(!$page = $_REQUEST['page']) $page = 1;

if(!$listnum)$listnum = 10;
$sql = "SELECT COUNT(*) FROM TAB_FORM_CSS where num_oid = $_OID";


$total = $DB->sqlFetchOne($sql);
if(!$total) $total = 0;


$page = $_REQUEST['page'];
if (!$page) $page = 1;

$seek = $listnum * ($page - 1);
$offset = $seek + $listnum;



$sql = "
	select * from TAB_FORM_CSS where num_oid = $_OID order by num_mcode desc LIMIT $seek , $listnum   ";





$data = $DB->sqlFetchAll($sql);
for($ii=0; $ii<count($data); $ii++) {
	$sql = "select count(*) from TAB_FORM where num_oid = $_OID and num_mcode = ".$data[$ii][num_mcode]."";
	$data[$ii][counter] =  $DB -> sqlFetchOne($sql);

}



$tpl->assign(array(
'title'=>$title,
'LIST'=>$data,
'page'=>$page,
'total'=>$total,
'listnum'=>$listnum,

'itemPerPage'=>$itemPerPage
));





	


	$tpl->define("CONTENT", Display::getTemplate("form/admin/main.htm"));
	
	 break;
	case "POST":
$ids = $_POST['ids'];
$ids_in = "'".implode("','",$ids)."'";
if($mode == "delete") {

  $sql = "delete from TAB_FORM WHERE num_oid=$_OID and num_mcode = '$code' and num_serial IN (".$ids_in.")";

  $DB->query($sql);
  $DB->commit();
  

	
}

WebApp::moveBack();

	 break;
	}

?>