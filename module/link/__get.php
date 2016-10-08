<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: __get.php
* 작성일: 
* 작성자: 이범민
* 설  명: 
*****************************************************************
* 
*/
switch($param['key']) {
	case 'menu':
		$DB = &WebApp::singleton('DB');
		$sql = "SELECT str_url,str_target FROM TAB_CONTENT_URL WHERE  NUM_CATE=".$param['cate'];
		$data = $DB->sqlFetch($sql);
		
		$menu_url = $data[str_url];
		$menu_target = $data[str_target];
	//	list($menu_url,$menu_target) = array_values();
		return array(
			'menu_name'=>_('URL Link'),
			'menu_url'=>$menu_url,
			'menu_target'=>$menu_target,
			'admin_btn_text'=>'링크변경',
			'admin_url'=>array('act'=>'link.admin.edit','mcode'=>$param['mcode']),
           
			'admin_desc'=>'NOTE: 외부 URL은 <font color="#0000FF">http://</font> 를 포함한 전체 주소를 모두 넣으세요.<br> 다른 메뉴 주소를 붙여넣기 하실때는 <font color="#0000FF">http://주소/</font> 를 제외한 나머지 부분만 넣는것이 속도가 빠릅니다<br>
<font color="#0000FF">"mailto:메일주소"</font> 를 이용하여 이메일보내기 링크로 사용할 수도 있습니다.'
		);
		break;
}
?>
