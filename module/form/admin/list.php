<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2008-09-30
* �ۼ���: ������
* ��  ��:  �Է����� ���� ������ Ȯ��
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
$sql = "SELECT COUNT(*) FROM TAB_FORM where num_oid = '$_OID' and num_mcode = $code";


$total = $DB->sqlFetchOne($sql);
if(!$total) $total = 0;


$page = $_REQUEST['page'];
if (!$page) $page = 1;

$seek = $listnum * ($page - 1);
$offset = $seek + $listnum;

$sql = "
select * from TAB_FORM where num_oid = '$_OID' and num_mcode = $code
order by num_serial desc LIMIT $seek , $listnum ";

//echo  $sql;


if($data = $DB->sqlFetchAll($sql)) array_walk($data,'list_format');


$sql = "select 

 
 str_col_name, 
   str_col_type, str_col_width, str_col_admin, 
   str_value1, str_value2, str_value3, 
   str_value4, str_value5, str_not_null

 from TAB_FORM_CONFIG where num_oid = '$_OID' and num_mcode = '$code'  ";

$form_data = $DB -> sqlFetchAll($sql);
for($ii=0; $ii<count($form_data); $ii++) {
	$form_data[$ii][str_col_name] = cut_str($form_data[$ii][str_col_name] , 10);
}


if(!$form_data ) {
	echo '<script>alert("��û�׸��� �������� �ʾҽ��ϴ�. ���� ������ �׸��� �����ϼ���.");</script>';
	echo "<meta http-equiv='Refresh' Content=\"0; URL='/form.admin.setup?code=$code&admin=$admin'\">";
	exit;
}




$sql = "select 
count(*)
 from TAB_FORM_CONFIG where num_oid = '$_OID' and num_mcode = '$code' ";

$form_total = $DB -> sqlFetchOne($sql);

$tpl->assign(array(
'title'=>$title,
'LIST'=>$data,
'form_data'=>$form_data,
'form_total'=>$form_total,
'page'=>$page,
'total'=>$total,
'listnum'=>$listnum,

'itemPerPage'=>$itemPerPage,
 'mode'=>$mode,
 'code'=>$code,
));





	

	
	$tpl->define("CONTENT", Display::getTemplate("form/admin/list.htm"));
	
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