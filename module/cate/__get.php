<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: __get.php
* �ۼ���: 
* �ۼ���: �̹���
* ��  ��: 
*****************************************************************
* 
*/
switch($param['key']) {
	case 'menu':
		return array(
			'menu_name'=>_('Blank Menu'),
			'menu_url'=>'javaScript:;',
			'admin_btn_text'=>'�޴����� ����',
			'admin_url'=>array('act'=>'menu.admin.settype','mcode'=>$param['mcode']),
			'admin_desc'=>''
		);
		break;
    case 'icon':
        return 'image/icon/folder.png';
}
?>
