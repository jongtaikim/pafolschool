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
		$typeArr = array('B'=>_('게시판형'),'G'=>_('겔러리형'));
		

		$typeArrUrl = array();
		$typeArrUrl['B'] = array('act'=>'board.list','mcode'=>$param['mcode'],'cate'=>$param['cate']);
		$typeArrUrl['G'] = array('act'=>'board.list','mcode'=>$param['mcode'],'cate'=>$param['cate']);
		

		return array(
			'menu_name'=>$typeArr[$param['module_type']],
			'menu_url'=>$typeArrUrl[$param['module_type']],
            'rights'=>array('l'=>'목록보기','r'=>'읽기','w'=>'쓰기','a'=>'관리'),
            'default_rights'=>'lr',
			'default_group_rights'=>'lr',
			'admin_btn_text'=>'게시판 옵션변경',
			'admin_url'=>array('act'=>'board.admin.manage.basic','mcode'=>$param['mcode']),
            'admin_tabs' => array(
                 '첨부파일 관리' => 'manage.file_view?mcode='.$param['mcode']
            ),
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
