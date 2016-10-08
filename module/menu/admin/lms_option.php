<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/admin/menu/option.php
* 작성일: 2004-01-26
* 작성자: 거친마루
* 설  명: 메뉴 옵션을 수정하는 화면
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');
$_OID = WebApp::getConf('oid');
$mcode = $_REQUEST['mcode'];

switch (REQUEST_METHOD) {

	case "GET":
		$env = array('showopt' => true);
		$data = $DB->sqlFetch("SELECT * FROM ".TAB_MENU." WHERE num_oid=$_OID AND num_mcode=$mcode");

	
	
    list($module_name,$module_type) = explode('#',$data['str_type']);

		$ext_data = WebApp::get($module_name,array('key'=>'menu','mcode'=>$mcode,'module_type'=>$module_type));
		if(is_array($ext_data['admin_url'])) $ext_data['admin_url'] = $URL->setVar($ext_data['admin_url']);
		if(is_array($ext_data['menu_url'])) $ext_data['menu_url'] = $URL->setVar($ext_data['menu_url']);
		

		// {{{ 메뉴위치 로케이션바 만들기
		$_mcode = $mcode;
		while(strlen($_mcode = substr($_mcode,0,-2)) > 1) {
			$_location[] = $DB->sqlFetchOne("SELECT str_title FROM ".TAB_MENU." WHERE num_oid=$_OID AND num_mcode=$_mcode");
		}
		$_location[] = '메인';
		$menu_location = implode(' > ',array_reverse($_location));
		// }}}

        $sub_cnt = $DB->sqlFetchOne("SELECT COUNT(*) FROM ".TAB_MENU." WHERE num_oid=$_OID AND num_mcode LIKE '".$mcode."__'");



		$tpl->setLayout('admin');
		$tpl->define('CONTENT', Display::getTemplate('menu/admin/lms_option.htm'));
        $tpl->assign('TABS',&$ext_data['admin_tabs']);
		$tpl->assign($data);
		$tpl->assign($ext_data);
		$tpl->assign(array(
            'menu_location' => $menu_location,
             'str_title2' => $data[str_title],
			'env'           => $env,
            'mcode'         => $mcode,
            'sub_cnt'       => $sub_cnt
        ));
		$tpl->assign();
		break;
/// {{{ 저장하는 부분
	case "POST":

        $what = $_POST['what'];
        $mcode = $URL->vars['mcode'];
        $new_title = $_POST['str_title'];
        $num_view = $_POST['num_view'] ? 1 : 0;
        $menu_type = $DB->sqlFetchOne("SELECT str_type FROM tab_menu WHERE num_oid=$_OID AND num_mcode=$mcode");
        
        $sql = "UPDATE tab_menu SET str_title='$new_title',num_view=$num_view WHERE num_oid=$_OID AND num_mcode=$mcode";
        if ($DB->query($sql)) {
            $DB->commit();

            $FTP = &WebApp::singleton("FtpClient",WebApp::getConf('account'));
            $FTP->delete($_DOC_ROOT.'/hosts/'.$HOST.'/menu.xml');


            deleteCacheFiles($mcode);
            
            echo "<script type='text/javascript'>try { parent.frames['menu'].reloadParent(); } catch(e) { };</script>";
            WebApp::redirect('menu.admin.option?mcode='.$mcode); //,'저장하였습니다');
        } else {
            $errors = $DB->error;
            WebApp::moveBack("<!> 변경사항을 저장하지 못했습니다.\n코드: $errors[code]\n에러: $errors[message]\n문장: $errors[sqltext]");
        }
		break;
// }}}

// {{{ Functions
function cb_admin_tabs(&$arr,$key,$mcode) {
    $arr = sprintf($arr,$mcode);
}
// }}}
}

?>
