<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/party/link/__get.php
* 작성일: 2006-05-17
* 작성자: 이범민
* 설  명: 
*****************************************************************
* 
*/
switch($param['key']) {
	case 'menu':
		return array(
    		'menu_name'=>_('URL Link'),
			'menu_url'=>'#',
			'menu_target'=>'_self',
			'admin_btn_text'=>'링크변경',
			'admin_url'=>array('act'=>'party.link.admin.edit','pcode'=>$param['pcode'],'mcode'=>$param['mcode']),
            'admin_tabs' => array(
                '링크변경' => 'party.link.admin.edit?pcode='.$param['pcode'].'&mcode='.$param['mcode']
            ),
			'admin_desc'=>'URL을 변경하시려면 메뉴주소에 직접 수정하는것이 아니고<br> 링크변경  버튼을 눌러 수정하셔야합니다'
		);
		break;
}
?>
