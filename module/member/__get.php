<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: __get.php
* �ۼ���: 
* �ۼ���: ����ĳ
* ��  ��: 
*****************************************************************
* 
*/
switch($param['key']) {
    case 'member_types':
	//�б�����Ʈ�� �׷��ø���. �����ڿ��� ����.
	//$_member_type = WebApp::getConf('member_type');
	//abcdefghijklmnopqrstuvwx

		return array(
		'n' => '��ȸ��',
		
		's' => '�л�',
		'g' => '�кθ�',
	
		'm' => '����',
		'z' => '�ְ������' );
	


    case 'office_member_types':
		//�¶��α����� �㰡�׷�
		return array(
		't' => '������',
		
		'd' => '�߰�������3', 
		'c' => '�߰�������2', 
		'b' => '�߰�������1', 
		'a' => '�ְ������' );

	case 'menu':
		
		$typeArr = array('L'=>_('�α���'),'F'=>_('ID/��й�ȣã��'),'J'=>_('ȸ������'),'M'=>_('ȸ����������'),'D'=>_('Ż��'),'A'=>_('����������ȣ��å'),'B'=>_('�̿���'));
		$typeArrUrl = array();
		$typeArrUrl['L'] = array('act'=>'member.login','mcode'=>$param['mcode']);
		$typeArrUrl['F'] = array('act'=>'member.findid','mcode'=>$param['mcode']);
		$typeArrUrl['J'] = array('act'=>'member.join','mcode'=>$param['mcode']);
		$typeArrUrl['M'] = array('act'=>'member.modify','mcode'=>$param['mcode']);
		$typeArrUrl['D'] = array('act'=>'member.del','mcode'=>$param['mcode']);
		$typeArrUrl['A'] = array('act'=>'member.chk1','mcode'=>$param['mcode']);
		$typeArrUrl['B'] = array('act'=>'member.chk2','mcode'=>$param['mcode']);
	
		$r_array =  array(
			'menu_name'=>$typeArr[$param['module_type']],
			'menu_url'=>$typeArrUrl[$param['module_type']],

            'rights'=>array('r'=>'��������','l'=>'Ż��'),
            'default_rights'=>'rl',
			'default_group_rights'=>'rl',
			'admin_desc'=>''
		);
		
		return $r_array;
		break;


		case 'leftmenu':
		
		$menu = array();

		if($_SESSION[USERID]) {
			
		
		$cate1 = 0;
		$menu[$cate1]['str_title'] = "����������";
		$menu[$cate1]['str_link'] = "member.mypage";

		$cate1 = 1;
		$menu[$cate1]['str_title'] = "ȸ����������";
		$menu[$cate1]['str_link'] = "member.modify";

		
		$cate1 = 2;
		$menu[$cate1]['str_title'] = "ȸ��Ż���ϱ�";
		$menu[$cate1]['str_link'] = "member.del";

		}else{
		
		$cate1 = 0;
		$menu[$cate1]['str_title'] = "�α���";
		$menu[$cate1]['str_link'] = "javascript:login();";

		$cate1 = 1;
		$menu[$cate1]['str_title'] = "���̵� ��� ã��";
		$menu[$cate1]['str_link'] = "member.findid";

		$cate1 = 2;
		$menu[$cate1]['str_title'] = "����������ȣ��å����";
		$menu[$cate1]['str_link'] = "admin.pra_view?mode=pra&layout=sub";

		
		}
			
		return $menu;
		
		break;
    case 'icon':
        return 'image/iicon/chart_bar.gif';

}



?>