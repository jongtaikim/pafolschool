<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2008-01-30
* �ۼ���: ������
* ��  ��: �����Ӹ�~!
*****************************************************************
* 
*/
$mode = $_REQUEST['mode'];
$varname = $_REQUEST['varname'];
$mcode = $_REQUEST['mcode'];
$step = $_REQUEST['step'];
$id = $_REQUEST['id'];
$nextstep = $step + 1;
$depthArr = array(
	1 => '::����::',
	2 => '::1��::',
	3 => '::2��::',
	4 => '::3��::'
);


if($mode == 'lms'){	//����ī�װ�
	$type = "lms#C";
	$type2 = "lms#A";
}elseif($mode == 'tach'){	//����ī�װ�
	$type = "lms#J";
	$type2 = "lms#E";
}elseif($mode == 'book'){	//����ī�װ�
	$type = "lms#B";
	$type2 = "lms#D";
}
if($type) {
	$psql = "and str_type in ('$type','$type2')  ";
}

$DB = &WebApp::singleton('DB');
$sql = "SELECT * FROM ".TAB_MENU." WHERE num_oid=$_OID $psql AND num_mcode LIKE '".$mcode."__' ORDER BY NUM_STEP";

if($data = $DB->sqlFetchAll($sql)) {
	$options = "<option value='' style='color:#666666;'>".$depthArr[$nextstep]."</option>";
	
	if($type) {
		foreach($data as $row){
			if($row[str_type] == $type || $row[str_type] == $type2 || $row[str_type] == 'menu'){
				$options .= "<option value='".$row['num_mcode']."'>".$row['str_title']."</option>";
				}
		}
	}else{
		foreach($data as $row) $options .= "<option value='".$row['num_mcode']."'>".$row['str_title']."</option>";
	}

	echo "document.getElementById('$id').innerHTML = \"<select name='".$varname.$nextstep."' id='".$varname.$nextstep."' step='$nextstep' onchange='selectmcode1(this);' align='absmiddle' style='font-size:11px;' style='font-size:9pt;height:150px' multiple  class=selector >$options</select><span id='dynArea".$nextstep."_1' style='padding-left:4px'></span>\";";

} else {
	echo "document.getElementById('$id').innerHTML = '';";
}
exit;
?>