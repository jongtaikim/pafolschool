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
	$data = $DB->sqlFetch("SELECT * FROM ".TAB_MENU." WHERE NUM_OID=$_OID AND NUM_MCODE=$mcode");
	


	
	
	
    list($module_name,$module_type) = explode('#',$data['str_type']);

		$ext_data = WebApp::get($module_name,array('key'=>'menu','mcode'=>$mcode,'module_type'=>$module_type));
		if(is_array($ext_data['admin_url'])) $ext_data['admin_url'] = $URL->setVar($ext_data['admin_url']);
		if(is_array($ext_data['menu_url'])) $ext_data['menu_url'] = $URL->setVar($ext_data['menu_url']);
		

		// {{{ 메뉴위치 로케이션바 만들기
		$_mcode = $mcode;
		while(strlen($_mcode = substr($_mcode,0,-2)) > 1) {
			$_location[] = $DB->sqlFetchOne("SELECT str_title FROM ".TAB_MENU." WHERE NUM_OID=$_OID AND NUM_MCODE=$_mcode");
		}
		$_location[] = '메인';
		$menu_location = implode(' > ',array_reverse($_location));
		// }}}

        $sub_cnt = $DB->sqlFetchOne("SELECT COUNT(*) FROM ".TAB_MENU." WHERE NUM_OID=$_OID AND NUM_MCODE LIKE '".$mcode."__'");

		$sql = "select STR_SKIN from TAB_BOARD_CONFIG where NUM_OID = '$_OID' and NUM_MCODE = '$mcode' ";
		$data[skin] = $DB -> sqlFetchOne($sql);

		 $skinlist = array();
		foreach (glob('html/board/skin/*',GLOB_ONLYDIR) as $str_skin) {
            $str_skin = array_pop(explode('/',$str_skin));
            $skininfo = @parse_ini_file("html/board/skin/{$str_skin}/skin.conf.php");
            $skinlist[] = array(
                'str_skin' => $str_skin,
                'skin_name' => $skininfo['name']
            );
		}


		 $skinlist2 = array();
		foreach (glob('html/mov_board/skin/*',GLOB_ONLYDIR) as $str_skin) {
            $str_skin = array_pop(explode('/',$str_skin));
            $skininfo = @parse_ini_file("html/mov_board/skin/{$str_skin}/skin.conf.php");
            $skinlist2[] = array(
                'str_skin' => $str_skin,
                'skin_name' => $skininfo['name']
            );
		}

		$tpl->setLayout('admin');
		$tpl->define('CONTENT', Display::getTemplate('menu/admin/option_mini.htm'));
        $tpl->assign('TABS',&$ext_data['admin_tabs']);
		$tpl->assign($data);
		$tpl->assign($ext_data);
		$tpl->assign(array(
            'menu_location' => $menu_location,
			  'bbs_skin' => $skinlist, 
			'mov_skin' => $skinlist2,
			'env'           => $env,
            'mcode'         => $mcode,
            'sub_cnt'       => $sub_cnt
        ));
		$tpl->assign();
		break;
/// {{{ 저장하는 부분
	case "POST":
		exec("rm -rf "._DOC_ROOT.'/hosts/'.HOST.'/'."inc_menu/*.htm");

        $what = $_POST['what'];
        $mcode = $URL->vars['mcode'];
        $new_title = $_POST['str_title'];
        $str_subtitlebar = $_POST['str_subtitlebar'];
        $num_view = $_POST['num_view'] ? 1 : 0;
        $menu_type = $DB->sqlFetchOne("SELECT STR_TYPE FROM TAB_MENU WHERE NUM_OID=$_OID AND NUM_MCODE=$mcode");


			$sql = "UPDATE TAB_MENU SET 
						
						STR_SUBTITLEBAR = '".$str_subtitlebar."' 
					   WHERE NUM_OID=$_OID AND NUM_MCODE=$mcode";
		

			$DB->query($sql);
            $DB->commit();



		if($str_width) {

			//2008-04-15 종태 게시판 명까지
			$sql = "UPDATE TAB_BOARD_CONFIG SET str_width='$str_width' WHERE NUM_OID=$_OID AND NUM_MCODE=$mcode";
			$DB->query($sql);
            $DB->commit();

			//2008-04-15 종태 게시판 명까지
			$sql = "UPDATE TAB_MENU SET str_width='$str_width' WHERE NUM_OID=$_OID AND NUM_MCODE=$mcode";
			$DB->query($sql);
			$DB->commit();

		}


		if($str_skin) {
			//2008-04-15 종태 게시판 명까지
			$sql = "UPDATE TAB_BOARD_CONFIG SET STR_SKIN='$str_skin' WHERE NUM_OID=$_OID AND NUM_MCODE=$mcode";
			$DB->query($sql);
            $DB->commit();	
		}
			$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
			unlink(_DOC_ROOT.'/hosts/'.HOST.'/conf/board/'.$mcode.'.conf.php');

        if ($DB->query($sql)) {
            $DB->commit();

            $FTP = &WebApp::singleton("FtpClient",WebApp::getConf('account'));
            unlink($_DOC_ROOT.'/hosts/'.$HOST.'/menu.xml');

            deleteCacheFiles($mcode);

		   if($etop == 'Y'){
	            WebApp::redirect(getenv("HTTP_REFERER")); //,'저장하였습니다');
		   }else{
				echo "<script>parent.location.reload();</script> ";
	            WebApp::redirect('menu.admin.option_mini?mcode='.$mcode); //,'저장하였습니다');
		   }
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
