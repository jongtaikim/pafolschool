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
	$typeArr = array('A'=>_('전체보기'),'C'=>_('개별'));
		

		$typeArrUrl = array();
		$typeArrUrl['A'] = array('act'=>'form.list','code'=>$param['code']);
		$typeArrUrl['C'] = array('act'=>'form.write','code'=>$param['code'],'mode'=>'write');
		
		return array(
			'menu_name'=>$typeArr[$param['module_type']],
			'menu_url'=>$typeArrUrl[$param['module_type']],
            'rights'=>array('l'=>'목록보기','r'=>'작성하기'),
            'default_rights'=>'lr',
			'default_group_rights'=>'lr',
			'admin_btn_text'=>'데이터 보기',
			'admin_url'=>array('act'=>'/form.admin.list','code'=>$param['code']),
         
			'admin_desc'=>''
		);
		break;
		case 'leftmenu':
		
		$menu = array();


		$menu[$cate1]['str_title'] = "온라인신청";
		$menu[$cate1]['str_link'] = "form.list";
		

			
		return $menu;
}
?>
