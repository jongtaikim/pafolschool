<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: module/party/link/__get.php
* �ۼ���: 2006-05-17
* �ۼ���: �̹���
* ��  ��: 
*****************************************************************
* 
*/
switch($param['key']) {
	case 'menu':
		return array(
    		'menu_name'=>_('URL Link'),
			'menu_url'=>'#',
			'menu_target'=>'_self',
			'admin_btn_text'=>'��ũ����',
			'admin_url'=>array('act'=>'party.link.admin.edit','pcode'=>$param['pcode'],'mcode'=>$param['mcode']),
            'admin_tabs' => array(
                '��ũ����' => 'party.link.admin.edit?pcode='.$param['pcode'].'&mcode='.$param['mcode']
            ),
			'admin_desc'=>'URL�� �����Ͻ÷��� �޴��ּҿ� ���� �����ϴ°��� �ƴϰ�<br> ��ũ����  ��ư�� ���� �����ϼž��մϴ�'
		);
		break;
}
?>
