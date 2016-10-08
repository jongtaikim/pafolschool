<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: select.php
* 작성일: 2008-09-01
* 작성자: 김종태
* 설  명: 메뉴선택 select 박스 출력
*****************************************************************
* 
*/
if(!$mcode = $param['mcode']) $mcode = $param['value'];
if(!$typeto = $param['typeto']) $typeto = $param['typeto'];

$tpl = &WebApp::singleton('Display');

switch ($param['typeto']) {
	case "board":

	break;

	case "doc_board":
		
	break;

	case "lms":	//강좌카테고리
		$type = "lms#C";
		$type2 = "lms#A";

	break;

	case "tach":	//강사카테고리
		$type = "lms#J";
		$type2 = "lms#E";

	break;

	case "book":	//교재카테고리
		$type = "lms#B";
		$type2 = "lms#D";

	break;

	default:

	break;
}


if($type) {
	$psql = "and str_type in ('$type','$type2')  ";
}

$DB = &WebApp::singleton('DB');
$sql = "select num_mcode, str_title from TAB_MENU where num_oid = "._OID." $psql order by num_mcode,num_step asc";
$row = $DB->sqlFetchAll($sql);

for($a=0 ; $a<sizeof($row) ; $a++){
	$c = ceil(strlen($row[$a][num_mcode])/2)-1;
	for($b=$c ; $b>=1 ; $b--){
		$c_mcode = -($b*2);
		$sql = "select str_title from TAB_MENU where num_oid = "._OID." and num_mcode = ".substr($row[$a][num_mcode],0,$c_mcode);
		$cat_sub_title = $DB -> sqlFetchOne($sql);
		$cat_sub .= $cat_sub_title." > ";
	}
	$cate_list[$a][stitle] = $cat_sub.$row[$a][str_title];
	$cate_list[$a][mcode] = $row[$a][num_mcode];
	unset($cat_sub);
}
$tpl->assign(array(
	'CATE_LIST'	=>	$cate_list,
));

$template = $param['template'];
$tpl->define('cateselectWA_',$template);
$content = $tpl->fetch("cateselectWA_");
echo $content;
?>