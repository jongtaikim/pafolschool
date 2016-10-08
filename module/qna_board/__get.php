<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: __get.php
* 작성일: 2005-03-31
* 작성자: 이범민
* 설  명: 
*****************************************************************
* 
*/
switch($param['key']) {
	case 'menu':
		//$typeArr = array('B'=>_('Bulletin Board'),'G'=>_('Image Gallery'));
		return array(
			'menu_name'=>$typeArr[$param['module_type']],
			'menu_url'=>array('act'=>'qna_board.list','mcode'=>$param['mcode']),
            'rights'=>array('l'=>'목록보기','r'=>'읽기','w'=>'쓰기'),
            'default_rights'=>'lr',
			'default_group_rights'=>'lr',
			'admin_btn_text'=>'신규질문 추가',
			'admin_url'=>array('act'=>'qna_board.write','mcode'=>$param['mcode']),
            'admin_tabs' => array(
                '신규질문 추가' => 'qna_board.write?mcode='.$param['mcode']
            ),
		   
			'admin_desc'=>''
		);
		break;
 
}
?>
