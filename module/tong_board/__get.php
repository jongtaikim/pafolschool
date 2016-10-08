<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: __get.php
* 작성일: 2008-12-04
* 작성자: 김종태
* 설  명: 
*****************************************************************
* 
*/
switch($param['key']) {
	case 'menu':
		$typeArr = array('B'=>_('통합게시판'));
		

		$typeArrUrl = array();
		$typeArrUrl['B'] = array('act'=>'tong_board.list','mcode'=>$param[mcode],'cate'=>$param[cate]);

		

		return array(
			'menu_name'=>$typeArr[$param['module_type']],
			'menu_url'=>$typeArrUrl[$param['module_type']],
            'rights'=>array('l'=>'목록보기','r'=>'읽기','w'=>'쓰기','a'=>'관리'),
            'default_rights'=>'l',
			'default_group_rights'=>'l',
			'admin_btn_text'=>'통합게시판 옵션변경',

			'admin_desc'=>''
		);
		break;
    case 'icon':
        if ($param['module_type'] == 'B')
            return 'image/icon/discuss.gif';
        elseif ($param['module_type'] == 'G')
            return 'image/icon/image.gif';
        break;
}
?>
