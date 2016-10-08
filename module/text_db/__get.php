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
		
		return array(
			'menu_name'=>"용어사전",
			'menu_url'=>array('act'=>'text_db.list','mcode'=>$param['mcode'],'cate'=>$param['cate']),
			 'rights'=>array('l'=>'목록보기','r'=>'읽기','w'=>'쓰기','a'=>'관리'),
	            'default_rights'=>'lr',
			'default_group_rights'=>'lr',
		
		);
		break;
}
?>
