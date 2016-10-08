<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: __get.php
* 작성일: 
* 작성자: 이범민
* 설  명: 
*****************************************************************
* 
*/
switch($param['key']) {
	case 'menu':
		$DB = &WebApp::singleton('DB');
		$sql = "SELECT STR_URL,STR_TARGET FROM TAB_CONTENT_URL WHERE NUM_OID="._OID." AND NUM_MCODE=".$param['mcode'];
		list($menu_url,$menu_target) = array_values($DB->sqlFetch($sql));
		return array(
			'menu_name'=>_('아이프레임'),
			'menu_url'=>array('act'=>'ifr.go','mcode'=>$param['mcode']),
		      'rights'=>array('l'=>'페이지열기'),
            'default_rights'=>'l',
			'default_group_rights'=>'l',
			'menu_target'=>$menu_target,
		
		
         
		
		);
		break;
}
?>
