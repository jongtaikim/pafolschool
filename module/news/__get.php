<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: __get.php
* �ۼ���: 2008-10-06
* �ۼ���: ������
* ��  ��: 
*****************************************************************
* 
*/
switch($param['key']) {
	case 'menu':
			return array(
			'menu_name'=>'��������',
			'menu_url'=>array('act'=>'news.list','mcode'=>$param['mcode'],'code'=>"news"),
            'rights'=>array('l'=>'��Ϻ���','r'=>'�б�','w'=>'����'),
            'default_rights'=>'lr',
			'default_group_rights'=>'lr',
			
			'admin_desc'=>''
		);
		break;
		case 'leftmenu':
		
		
		break;


}
?>
