<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: __get.php
* �ۼ���: 2008-10-18 
* �ۼ���: ������
* ��  ��: 
*****************************************************************
* 
*/

switch($param['key']) {
	case 'menu':
		$typeArr = array('A'=>_('ȣ��Ʈ��Ȳ'),'C'=>_('ȣ��Ʈ ����'),'O'=>_('������Ʈ����'));
		$typeArrUrl = array();
		$typeArrUrl['A'] = array('act'=>'manage.organ','mcode'=>$param['mcode'],'cate'=>$param['cate']);
		$typeArrUrl['C'] = array('act'=>'manage.makehost','mcode'=>$param['mcode'],'cate'=>$param['cate']);
		$typeArrUrl['O'] = array('act'=>'manage.mk_module','mcode'=>$param['mcode'],'cate'=>$param['cate']);
		//$typeArrUrl['M'] = array('act'=>'manage.organ_view_all','mcode'=>$param['mcode']);

		//array('l'=>'��Ϻ���','r'=>'�󼼺���','w'=>'ȣ��Ʈ����','m'=>'��躸��'),
	
		$typerights = array();
		$typerights['A'] = array('l'=>'��Ϻ���');
		$typerights['C'] = array('w'=>'ȣ��Ʈ����');
		$typerights['O'] = array('r'=>'������Ʈ����','m'=>'������Ʈ����');
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
