<?php

switch($param['key']) {
	case 'menu':
		$typeArr = array('A'=>_('���ǰԽ���'),'B'=>_('�ϹݰԽ���'));

		$typeArrUrl = array();
		$typeArrUrl['A'] = array('act'=>'party.board.list','pcode'=>$param['pcode'],'mcode'=>$param['mcode']);
		$typeArrUrl['B'] = array('act'=>'cafe/'.$param['pcode'].'/'.$param['mcode']);

		return array(
			'menu_name'=>$typeArr[$param['module_type']],
			'menu_url'=>array('act'=>'party.board.list','pcode'=>$param['pcode'],'mcode'=>$param['mcode']),
            'rights'=>array('l'=>'��Ϻ���','r'=>'�б�','w'=>'����'),
            'default_rights'=>'lr',
			'admin_desc'=>''
		);
		break;

}

