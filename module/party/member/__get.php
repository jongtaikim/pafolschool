<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: __get.php
* �ۼ���: 
* �ۼ���: ����ĳ
* ��  ��: 
*****************************************************************
* 
*/

switch($param['key']) {
    case 'member_types':
		
		switch(_CAFETYPE) {
		case 'cafe':
			return array(
				'x' => "��ȸ��",
				'w' => "�������",
				'v'=> "����ȸ��",
				'u' => "��ȸ��",
				't' => "��ȸ��",
				's'=> "���ȸ��",
				'b'=> "�θŴ���",
				'a'=> "�Ŵ���");
		break;
		case 'class':
			return array(
				'x' => "��ȸ��",
				'w' => "�������",
				'v'=> "����ȸ��",
				'u' => "��ȸ��",
				't' => "��ȸ��",
				's'=> "���ȸ��",
				'b'=> "�ο��",
				'a'=> "���Ӽ�����");
		break;
		case 'office':
			return array(
				'x' => "��ȸ��",
				'w' => "�������",
				'v'=> "����ȸ��",
				'u' => "��ȸ��",
				't' => "��ȸ��",
				's'=> "���ȸ��",
				'b'=> "�θŴ���",
				'a'=> "�Ŵ���");
		break;
		}


	case 'menu':
		
		$typeArr = array('A'=>_('ī�䰡��'));
		$typeArrUrl = array();
		$typeArrUrl['L'] = array('act'=>'party.member.join','pcode'=>$param['pcode']);
	
		$r_array =  array(
			'menu_name'=>$typeArr[$param['module_type']],
			'menu_url'=>$typeArrUrl[$param['module_type']],
/*
            'rights'=>array('r'=>'��������','l'=>'Ż��'),
            'default_rights'=>'rl',
			'default_group_rights'=>'rl',
			'admin_desc'=>''
*/
		);

		return $r_array;
		break;
    case 'icon':
        return 'image/iicon/chart_bar.gif';

}



?>