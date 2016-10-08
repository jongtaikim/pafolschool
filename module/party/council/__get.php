<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/party/council/__get.php
* 작성일: 2006-05-17
* 작성자: 이범민
* 설  명: 
*****************************************************************
* 
*/
switch($param['key']) {
	case 'menu':
		return array(
			'menu_name'=>_('Counselling Room'),
			'menu_url'=>array('act'=>'party.council.list','pcode'=>$param['pcode'],'mcode'=>$param['mcode']),
            'rights'=>array('l'=>'목록보기','r'=>'읽기','w'=>'쓰기'),
            'default_rights'=>'l',
			'admin_btn_text'=>'옵션변경',
			'admin_url'=>array('act'=>'party.council.admin.manage','pcode'=>$param['pcode'],'mcode'=>$param['mcode']),
			'admin_tabs' => array(
                '상담실설정' => 'party.council.admin.manage?pcode='.$param['pcode'].'&mcode='.$param['mcode']
            ),
			'admin_desc'=>''
		);
		break;
}
?>