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
			'menu_name'=>"������",
			'menu_url'=>array('act'=>'text_db.list','mcode'=>$param['mcode'],'cate'=>$param['cate']),
			 'rights'=>array('l'=>'��Ϻ���','r'=>'�б�','w'=>'����','a'=>'����'),
	            'default_rights'=>'lr',
			'default_group_rights'=>'lr',
		
		);
		break;
}
?>
