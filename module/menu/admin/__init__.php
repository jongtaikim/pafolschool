<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: __init__.php
* �ۼ���: 2008-12-04
* �ۼ���: ������
* ��  ��: �޴�����
*****************************************************************
* 
*/
include_once "module/admin/__init__.php";


/*	if(strlen($parent) % 2 == 0) { //2008-01-02 ���� 2�ڸ� �϶� ����	

		$VAR_MENUTYPE = array(
		
		'menu' => _('Blank Menu'),
		'board#B' => _('Bulletin Board'),

		'doc_board' => _('HTML Document'),

		'link' => _('URL Link'),
		'lms' => _('����������(ī�װ�)'),
		'qna_board' => _('QNA��'),
		);
		
		}else{
		
*/

		if($_OID == _AOID) {
		$VAR_MENUTYPE = array(
		'menu' => _('��޴�'),
		'board#B' => _('�Խ���'),
		'tong_board#B' => _('�����Խ���'),

		'doc' => _('HTML Document'),


		'link' => _('URL Link'),
		
		'member#L' => _('�α���'),
		'member#F' => _('IDã��'),
		'member#J' => _('ȸ������'),
		'member#M' => _('ȸ����������'),
		'member#D' => _('ȸ��Ż��'),

		'qna_board' => _('QNA��'),
		'mov_board' => _('UCC��'),
		'form' => _('�Է���������'),
		'ifr' => _('����������'),
		'poll' => _('��������'),
		'board#A' => _('�Խù���ü����(����)'),
		'sitemap' => _('����Ʈ��'),
		'member#A' => _('����������ȣ��å'),
		'member#B' => _('����Ʈ�̿���'),
		'pay#A' => _('��ٱ��ϸ���Ʈ'),
		);
		}else{
		$VAR_MENUTYPE = array(
		'menu' => _('��޴�'),
		'board#B' => _('Bulletin Board'),

		'doc' => _('������'),

		'link' => _('URL Link'),
		'ifr' => _('����������'),
		'text_db' => "������",

		);
		}




//2008-11-25 ���� ��Ʈ����� ��� ó��

if(_AOID == $_OID ) {

	$VAR_MENUTYPE2 = array(
			'manage#A' => _('ȣ��Ʈ ��Ȳ'),
			'manage#C' => _('ȣ��Ʈ����'),
			'manage#O' => _('������Ʈ����'),
			'sitemap' => _('����Ʈ��'),
			'member#L' => _('�α���'),
			'member#F' => _('IDã��'),
			'member#J' => _('ȸ������'),
			'member#M' => _('ȸ����������'),
			'member#D' => _('ȸ��Ż��'),
			'member#A' => _('����������ȣ��å'),
			'member#B' => _('����Ʈ�̿���'),

		);
}else{
	$VAR_MENUTYPE2 = array(
	
		);
}

	
//}


function deleteCacheFiles($mcode) {
    $FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
    if(strlen($mcode) % 2) {
        $FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/menu/smenu.htm');
    } else {
        $_mcode = substr($mcode,0,2);
        $FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/menu/'.$_mcode.'.htm');
		$FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/menu/'.$mcode.'.htm');
        $FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/menu.xml');
        $FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/menu2.xml');
		$FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/cate.xml');
 		$FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/url.xml');
    }
}


include _DOC_ROOT.'/module/media.php';

?>