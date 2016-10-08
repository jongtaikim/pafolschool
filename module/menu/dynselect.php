<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-01-30
* 작성자: 김종태
* 설  명: 몰라임마~!
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
	1 => '::메인::',
	2 => '::1차::',
	3 => '::2차::',
	4 => '::3차::'
);


if($mode == 'lms'){	//강좌카테고리
	$type = "lms#C";
	$type2 = "lms#A";
}elseif($mode == 'tach'){	//강사카테고리
	$type = "lms#J";
	$type2 = "lms#E";
}elseif($mode == 'book'){	//교재카테고리
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