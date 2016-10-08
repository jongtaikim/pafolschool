<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: __get.php
* 작성일: 2008-10-06
* 작성자: 김종태
* 설  명: 
*****************************************************************
* 
*/
switch($param['key']) {
	case 'menu':
			return array(
			'menu_name'=>'뉴스레터',
			'menu_url'=>array('act'=>'news.list','mcode'=>$param['mcode'],'code'=>"news"),
            'rights'=>array('l'=>'목록보기','r'=>'읽기','w'=>'쓰기'),
            'default_rights'=>'lr',
			'default_group_rights'=>'lr',
			
			'admin_desc'=>''
		);
		break;
		case 'leftmenu':
		
		
		break;


}
?>
