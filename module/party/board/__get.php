<?php

switch($param['key']) {
	case 'menu':
		$typeArr = array('A'=>_('스탭게시판'),'B'=>_('일반게시판'));

		$typeArrUrl = array();
		$typeArrUrl['A'] = array('act'=>'party.board.list','pcode'=>$param['pcode'],'mcode'=>$param['mcode']);
		$typeArrUrl['B'] = array('act'=>'cafe/'.$param['pcode'].'/'.$param['mcode']);

		return array(
			'menu_name'=>$typeArr[$param['module_type']],
			'menu_url'=>array('act'=>'party.board.list','pcode'=>$param['pcode'],'mcode'=>$param['mcode']),
            'rights'=>array('l'=>'목록보기','r'=>'읽기','w'=>'쓰기'),
            'default_rights'=>'lr',
			'admin_desc'=>''
		);
		break;

}

