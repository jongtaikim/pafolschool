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
$ccode = $_REQUEST['ccode'];
$step = $_REQUEST['step'];
$id = $_REQUEST['id'];
$nextstep = $step + 1;
$depthArr = array(
	1 => '::1��::',
	2 => '::2��::'
);



$DB = &WebApp::singleton('DB');
$sql = "SELECT * FROM ".TAB_PARTY_CATE." WHERE num_ccode LIKE '".$ccode."__'  $psql";

if($data = $DB->sqlFetchAll($sql)) {
	$options = "<option value='' style='color:#666666;'>".$depthArr[$nextstep]."</option>";
	
	if($type) {
		foreach($data as $row){
			if($row[str_type] == $type || $row[str_type] == $type2 || $row[str_type] == 'menu'){
				$options .= "<option value='".$row['num_ccode']."'>".$row['str_title']."</option>";
				}
		}
	}else{
		foreach($data as $row) $options .= "<option value='".$row['num_ccode']."'>".$row['str_title']."</option>";
	}


	
		echo "document.getElementById('$id').innerHTML = \"<select name='".$varname.$nextstep."' id='".$varname.$nextstep."' step='$nextstep' onchange='selectccode1(this);' align='absmiddle' style='font-size:11px;' style='font-size:9pt;'   class=selector >$options</select><span id='dynArea".$nextstep."_1' style='padding-left:4px'></span>\";";

	

} else {
	echo "document.getElementById('$id').innerHTML = '';";
}
exit;
?>