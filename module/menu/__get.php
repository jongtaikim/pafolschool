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
			'menu_name'=>_('Blank Menu'),
			'menu_url'=>array('act'=>'menu.blank','mcode'=>$param['mcode'],'cate'=>$param['cate']),
			'admin_btn_text'=>'메뉴형태 선택',
			'admin_url'=>array('act'=>'menu.admin.settype','mcode'=>$param['mcode']),
			'admin_desc'=>'빈메뉴를 만드시면 하위메뉴를 만드실 수 있습니다.'
		);
		break;
    case 'icon':
        return 'image/icon/folder.png';
}
?>
