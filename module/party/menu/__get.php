<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: module/party/doc/__get.php
* �ۼ���: 2006-05-17
* �ۼ���: �̹���
* ��  ��: 
*****************************************************************
* 
*/
switch($param['key']) {
	case 'menu':
		return array(
			'menu_name'=>_('HTML Document'),
			'menu_url'=>array('act'=>'party.doc.view','pcode'=>$param['pcode'],'mcode'=>$param['mcode']),
            'rights'=>array('r'=>'�б�'),
            'default_rights'=>'r',
			'admin_btn_text'=>'��������',
			'admin_url'=>array('act'=>'party.doc.admin.edit','pcode'=>$param['pcode'],'mcode'=>$param['mcode']),
            'admin_tabs' => array(
                '��������' => 'party.doc.admin.edit?pcode='.$param['pcode'].'&mcode='.$param['mcode']
            ),
			'admin_desc'=>''
		);
		break;
    case 'icon':
        return 'image/icon/html.png';
}
?>
