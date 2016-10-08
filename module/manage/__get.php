<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: __get.php
* 작성일: 2008-10-18 
* 작성자: 김종태
* 설  명: 
*****************************************************************
* 
*/

switch($param['key']) {
	case 'menu':
		$typeArr = array('A'=>_('호스트현황'),'C'=>_('호스트 생성'),'O'=>_('프로젝트메인'));
		$typeArrUrl = array();
		$typeArrUrl['A'] = array('act'=>'manage.organ','mcode'=>$param['mcode'],'cate'=>$param['cate']);
		$typeArrUrl['C'] = array('act'=>'manage.makehost','mcode'=>$param['mcode'],'cate'=>$param['cate']);
		$typeArrUrl['O'] = array('act'=>'manage.mk_module','mcode'=>$param['mcode'],'cate'=>$param['cate']);
		//$typeArrUrl['M'] = array('act'=>'manage.organ_view_all','mcode'=>$param['mcode']);

		//array('l'=>'목록보기','r'=>'상세보기','w'=>'호스트생성','m'=>'통계보기'),
	
		$typerights = array();
		$typerights['A'] = array('l'=>'목록보기');
		$typerights['C'] = array('w'=>'호스트생성');
		$typerights['O'] = array('r'=>'프로젝트생성','m'=>'프로젝트수정');
		//$typerights['M'] = array('act'=>'manage.organ_view_all','mcode'=>$param['mcode']);
	
	
		$main_arr =  array(
			'menu_name'=>$typeArr[$param['module_type']],
			'menu_url'=>$typeArrUrl[$param['module_type']],
            'rights'=>$typerights[$param['module_type']],
            'default_rights'=>'',
			'default_group_rights'=>'',

		   
			'admin_desc'=>''
		);
		
		return  $main_arr;

		break;

}
?>
