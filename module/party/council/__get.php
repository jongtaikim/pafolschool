<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: module/party/council/__get.php
* �ۼ���: 2006-05-17
* �ۼ���: �̹���
* ��  ��: 
*****************************************************************
* 
*/
switch($param['key']) {
	case 'menu':
		return array(
			'menu_name'=>_('Counselling Room'),
			'menu_url'=>array('act'=>'party.council.list','pcode'=>$param['pcode'],'mcode'=>$param['mcode']),
            'rights'=>array('l'=>'��Ϻ���','r'=>'�б�','w'=>'����'),
            'default_rights'=>'l',
			'admin_btn_text'=>'�ɼǺ���',
			'admin_url'=>array('act'=>'party.council.admin.manage','pcode'=>$param['pcode'],'mcode'=>$param['mcode']),
			'admin_tabs' => array(
                '���Ǽ���' => 'party.council.admin.manage?pcode='.$param['pcode'].'&mcode='.$param['mcode']
            ),
			'admin_desc'=>''
		);
		break;
}
?>