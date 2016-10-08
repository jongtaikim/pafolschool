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
if(!$varname = $param['varname']) $varname = $param['name'];
if(!$varname) $varname = 'num_mcode';
if(!$hname = $param['hname']) $hname = '서브페이지';

/*if($param['type']) {
if(strstr($param['type'],"#")){
$param['type'] = explode("#",$param['type']);
$param['type'] = $param['type'][0];
	
}

}*/
$tpl = &WebApp::singleton('Display');

switch ($param['typeto']) {
	case "board":
		$tpl->define("CATE_SELECT",'html/menu/select_board.htm');

	break;

	case "doc_board":
		
	break;

	case "lms":	//강좌카테고리
		$type = "lms#C";
		$type2 = "lms#A";
		$tpl->define("CATE_SELECT",'html/menu/select_1.htm');

	break;

	case "tach":	//강사카테고리
		$type = "lms#J";
		$type2 = "lms#E";
		$tpl->define("CATE_SELECT",'html/menu/select_1.htm');

	break;

	case "book":	//교재카테고리
		$type = "lms#B";
		$type2 = "lms#D";
		$tpl->define("CATE_SELECT",'html/menu/select_1.htm');

	break;

	default:
		$tpl->define("CATE_SELECT",'html/menu/select_1.htm');

	break;
}

$depthArr = array(
	1 => '::메인::',
	2 => '::1차::',
	3 => '::2차::',
	4 => '::3차::'

);

if($type) {
	$psql = "and str_type in ('$type','$type2')  ";
}

$DB = &WebApp::singleton('DB');
$sql = "SELECT * FROM ".TAB_MENU." WHERE num_oid="._OID." AND LENGTH(num_mcode) =2   ORDER BY num_step";
$main_cate = $DB->sqlFetchAll($sql);

$data[] = array(
	'step'		=> 1,
	'depth_str' => $depthArr[1],
	'cur_mcode'	=> substr($mcode,0,2),
	'OPTIONS'	=> $main_cate,
	'type' => $param['type'],
);


if($mcode) {
	for($i=2;$i<strlen($mcode)/2+2;$i++) {
		$pmccode = substr($mcode,0,($i-1)*2);
		$sql = "SELECT * FROM ".TAB_MENU." WHERE num_oid="._OID." $psql and num_mcode LIKE '".$pmccode."__' ORDER BY num_step";

		if($sub_data = $DB->sqlFetchAll($sql)) {
			$data[] = array(
				'step'		=> $i,
				'depth_str' => $depthArr[$i],
				'cur_mcode'=> substr($mcode,0,$i*2),
				'OPTIONS'	=> $sub_data
			);
		}
	}
}

$tpl->assign(array(
	'CATE_LIST'	=>	$data,
	'mcode'		=>	$mcode,
	'varname'	=>	$varname,
    'hname'     =>  $hname,
	'required'	=>	$param['required'],
	'typetypeto'	=>	$param['typeto'],
	'mode'	=>	$param['typeto'],
));
$tpl->print_("CATE_SELECT");
?>