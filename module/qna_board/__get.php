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
		//$typeArr = array('B'=>_('Bulletin Board'),'G'=>_('Image Gallery'));
		return array(
			'menu_name'=>$typeArr[$param['module_type']],
			'menu_url'=>array('act'=>'qna_board.list','mcode'=>$param['mcode']),
            'rights'=>array('l'=>'��Ϻ���','r'=>'�б�','w'=>'����'),
            'default_rights'=>'lr',
			'default_group_rights'=>'lr',
			'admin_btn_text'=>'�ű����� �߰�',
			'admin_url'=>array('act'=>'qna_board.write','mcode'=>$param['mcode']),
            'admin_tabs' => array(
                '�ű����� �߰�' => 'qna_board.write?mcode='.$param['mcode']
            ),
		   
			'admin_desc'=>''
		);
		break;
 
}
?>
