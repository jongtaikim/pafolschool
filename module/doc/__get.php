<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: __get.php
* �ۼ���: 2010-03-15
* �ۼ���: ������
* ��  ��: 
*****************************************************************
* 
*/
switch($param['key']) {
	case 'menu':
		return array(
			'menu_name'=>_('HTML Document'),
			'menu_url'=>array('act'=>'doc.view','mcode'=>$param['mcode'],'cate'=>$param['cate']),
            'rights'=>array('r'=>'�б�'),
            'default_rights'=>'r',
			'default_group_rights'=>'r',
			'admin_btn_text'=>'��������',
			'admin_url'=>array('act'=>'doc.admin.edit','mcode'=>$param['mcode']),
            'admin_tabs' => array(
                '��������' => 'doc.admin.edit?mcode='.$param['mcode']
            ),
			'admin_desc'=>''
		);
		break;
    case 'icon':
        return 'image/icon/html.png';
}
?>
