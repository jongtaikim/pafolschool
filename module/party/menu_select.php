<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: select.php
* �ۼ���: 2008-09-01
* �ۼ���: ������
* ��  ��: �޴����� select �ڽ� ���
*****************************************************************
* 
*/
if(!$ccode = $param['ccode']) $ccode = $param['ccode'];
if(!$varname = $param['varname']) $varname = $param['name'];
if(!$varname) $varname = 'num_ccode';
if(!$hname = $param['hname']) $hname = '����������';

/*if($param['type']) {
if(strstr($param['type'],"#")){
$param['type'] = explode("#",$param['type']);
$param['type'] = $param['type'][0];
	
}

}*/
$tpl = &WebApp::singleton('Display');

$tpl->define("CATE_SELECT",'html/party/select_1.htm');

$depthArr = array(
	1 => '::1��::',
	2 => '::2��::',


);


$DB = &WebApp::singleton('DB');
$sql = "SELECT * FROM ".TAB_PARTY_CATE." WHERE  LENGTH(num_ccode) =2  ";

$main_cate = $DB->sqlFetchAll($sql);

$data[] = array(
	'step'		=> 1,
	'depth_str' => $depthArr[1],
	'cur_ccode'	=> substr($ccode,0,2),
	'OPTIONS'	=> $main_cate,
	'type' => $param['type'],
);


if($ccode) {
	for($i=2;$i<strlen($ccode)/2+2;$i++) {
		$pmccode = substr($ccode,0,($i-1)*2);
		$sql = "SELECT * FROM ".TAB_PARTY_CATE." WHERE  num_ccode LIKE '".$pmccode."__' $psql";
		if($sub_data = $DB->sqlFetchAll($sql)) {
			$data[] = array(
				'step'		=> $i,
				'depth_str' => $depthArr[$i],
				'cur_ccode'=> substr($ccode,0,$i*2),
				'OPTIONS'	=> $sub_data
			);
		}
	}
}


$tpl->assign(array(
	'CATE_LIST'	=>	$data,
	'ccode'		=>	$ccode,
	'varname'	=>	$varname,
    'hname'     =>  $hname,
	'required'	=>	$param['required'],
	'typetypeto'	=>	$param['typeto'],
	'mode'	=>	$param['typeto'],
));
$tpl->print_("CATE_SELECT");
?>