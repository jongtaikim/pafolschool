<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: __get.php
* 작성일: 2010-03-15
* 작성자: 김종태
* 설  명: 
*****************************************************************
* 
*/
switch($param['key']) {
	case 'menu':
		return array(
			'menu_name'=>_('HTML Document'),
			'menu_url'=>array('act'=>'doc.view','mcode'=>$param['mcode'],'cate'=>$param['cate']),
            'rights'=>array('r'=>'읽기'),
            'default_rights'=>'r',
			'default_group_rights'=>'r',
			'admin_btn_text'=>'내용편집',
			'admin_url'=>array('act'=>'doc.admin.edit','mcode'=>$param['mcode']),
            'admin_tabs' => array(
                '내용편집' => 'doc.admin.edit?mcode='.$param['mcode']
            ),
			'admin_desc'=>''
		);
		break;
    case 'icon':
        return 'image/icon/html.png';
}
?>
