<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: __get.php
* �ۼ���: 2008-12-04
* �ۼ���: ������
* ��  ��: 
*****************************************************************
* 
*/
switch($param['key']) {
	case 'menu':
		$typeArr = array('B'=>_('���հԽ���'));
		

		$typeArrUrl = array();
		$typeArrUrl['B'] = array('act'=>'tong_board.list','mcode'=>$param[mcode],'cate'=>$param[cate]);

		

		return array(
			'menu_name'=>$typeArr[$param['module_type']],
			'menu_url'=>$typeArrUrl[$param['module_type']],
            'rights'=>array('l'=>'��Ϻ���','r'=>'�б�','w'=>'����','a'=>'����'),
            'default_rights'=>'l',
			'default_group_rights'=>'l',
			'admin_btn_text'=>'���հԽ��� �ɼǺ���',

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
