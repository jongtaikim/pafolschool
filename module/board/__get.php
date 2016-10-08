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
		$typeArr = array('B'=>_('�Խ�����'),'G'=>_('�ַ�����'));
		

		$typeArrUrl = array();
		$typeArrUrl['B'] = array('act'=>'board.list','mcode'=>$param['mcode'],'cate'=>$param['cate']);
		$typeArrUrl['G'] = array('act'=>'board.list','mcode'=>$param['mcode'],'cate'=>$param['cate']);
		

		return array(
			'menu_name'=>$typeArr[$param['module_type']],
			'menu_url'=>$typeArrUrl[$param['module_type']],
            'rights'=>array('l'=>'��Ϻ���','r'=>'�б�','w'=>'����','a'=>'����'),
            'default_rights'=>'lr',
			'default_group_rights'=>'lr',
			'admin_btn_text'=>'�Խ��� �ɼǺ���',
			'admin_url'=>array('act'=>'board.admin.manage.basic','mcode'=>$param['mcode']),
            'admin_tabs' => array(
                 '÷������ ����' => 'manage.file_view?mcode='.$param['mcode']
            ),
			'admin_desc'=>''
		);
		break;
    case 'icon':
        if ($param['module_type'] == 'B')
            return 'image/icon/discuss.gif';
        elseif ($param['module_type'] == 'G')
            return 'image/icon/image.gif';
        break;
}
?>
