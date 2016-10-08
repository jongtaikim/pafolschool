<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/party/doc/__get.php
* 작성일: 2006-05-17
* 작성자: 이범민
* 설  명: 
*****************************************************************
* 
*/
switch($param['key']) {
	case 'menu':
		return array(
			'menu_name'=>_('HTML Document'),
			'menu_url'=>array('act'=>'party.doc.view','pcode'=>$param['pcode'],'mcode'=>$param['mcode']),
            'rights'=>array('r'=>'읽기'),
            'default_rights'=>'r',
			'admin_btn_text'=>'내용편집',
			'admin_url'=>array('act'=>'party.doc.admin.edit','pcode'=>$param['pcode'],'mcode'=>$param['mcode']),
            'admin_tabs' => array(
                '내용편집' => 'party.doc.admin.edit?pcode='.$param['pcode'].'&mcode='.$param['mcode']
            ),
			'admin_desc'=>''
		);
		break;
    case 'icon':
        return 'image/icon/html.png';
}
?>
