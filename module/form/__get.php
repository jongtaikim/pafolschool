<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: __get.php
* �ۼ���: 2005-03-31
* �ۼ���: �̹���
* ��  ��: 
*****************************************************************
* 
*/
switch($param['key']) {
	case 'menu':
	$typeArr = array('A'=>_('��ü����'),'C'=>_('����'));
		

		$typeArrUrl = array();
		$typeArrUrl['A'] = array('act'=>'form.list','code'=>$param['code']);
		$typeArrUrl['C'] = array('act'=>'form.write','code'=>$param['code'],'mode'=>'write');
		
		return array(
			'menu_name'=>$typeArr[$param['module_type']],
			'menu_url'=>$typeArrUrl[$param['module_type']],
            'rights'=>array('l'=>'��Ϻ���','r'=>'�ۼ��ϱ�'),
            'default_rights'=>'lr',
			'default_group_rights'=>'lr',
			'admin_btn_text'=>'������ ����',
			'admin_url'=>array('act'=>'/form.admin.list','code'=>$param['code']),
         
			'admin_desc'=>''
		);
		break;
		case 'leftmenu':
		
		$menu = array();


		$menu[$cate1]['str_title'] = "�¶��ν�û";
		$menu[$cate1]['str_link'] = "form.list";
		

			
		return $menu;
}
?>
