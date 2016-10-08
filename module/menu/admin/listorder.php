<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: menu/admin/listorder.php
* 작성일: 2006-04-20
* 작성자: 이범민
* 설  명: 하위메뉴 순서변경
*****************************************************************
* 
*/

$DB = &WebApp::singleton('DB');


switch($REQUEST_METHOD) {
	case "GET":


	if($cate && strlen($cate) != 3) {
	$sql = "select str_title from TAB_MENU where num_oid = '$_OID' and num_cate = '".substr($cate,0,2)."'";

	$menu1 = $DB -> sqlFetchOne($sql);
	$tpl->assign(array('menu1'=>$menu1));

	if(strlen($cate) == 4) {
	$sql = "select str_title from TAB_MENU where num_oid = '$_OID' and num_cate = '".substr($cate,0,4)."'";
	$menu2 = $DB -> sqlFetchOne($sql);
	$tpl->assign(array('menu2'=>$menu2));		
	}

	if(strlen($cate) == 6) {
	$sql = "select str_title from TAB_MENU where num_oid = '$_OID' and num_cate = '".$cate."'";
	$menu3 = $DB -> sqlFetchOne($sql);
	$tpl->assign(array('menu2'=>$menu3));		
	}

	}


        $len = strlen($cate);
        if($len > 1) {
            if($data = $DB->sqlFetch("SELECT * FROM ".TAB_MENU." WHERE num_oid=$_OID AND num_cate=$cate")) {
                list($module_name,$module_type) = explode('#',$data['str_type']);
                $ext_data = WebApp::get($module_name,array('key'=>'menu','cate'=>$cate,'mcode'=>$code,'module_type'=>$module_type));
                if(is_array($ext_data['admin_url'])) $ext_data['admin_url'] = $URL->setVar($ext_data['admin_url']);
                if(is_array($ext_data['menu_url'])) $ext_data['menu_url'] = $URL->setVar($ext_data['menu_url']);
            }
        } elseif($len == 1) {
            $data = array('str_title' => '추가메뉴');
        } else {
            $data = array('str_title' => '메인메뉴');
        }

        $sql = "SELECT num_cate,str_title FROM ".TAB_MENU." WHERE num_oid=$_OID AND num_cate LIKE '".$cate."__' ORDER BY NUM_STEP";
        $list = $DB->sqlFetchAll($sql);

		$tpl->setLayout('admin');
        $tpl->define('CONTENT','html/menu/admin/listorder.htm');
        $tpl->assign(array(
            'cate' =>  $cate,
            'title' =>  $data['str_title'],
            'rights'=>  $ext_data['rights'],
            'TABS'  =>  $ext_data['admin_tabs'],
            'LIST'  =>  $list
        )); 
	break;
	case "POST":
	 	 exec("rm -rf "._DOC_ROOT.'/hosts/'.HOST.'/'."inc_menu/*.htm");
		 unlink(_DOC_ROOT.'/hosts/'.HOST.'/menu.xml');
		$cates = $_POST['cates'];
        foreach ($cates as $cate) {
            $i++;
            $DB->query("UPDATE ".TAB_MENU." SET num_step=$i , num_step_back=$i WHERE num_oid=$_OID AND num_cate=$cate");
			 unlink(_DOC_ROOT.'/hosts/'.HOST.'/'."inc_menu/".$cate.".htm");
        }
        if (!$DB->error) {
            $DB->commit();
            
            deleteCacheFiles($cate);

            echo '<script type="text/javascript">parent.frames["menu"].reloadSelected();</script>';
            WebApp::moveBack();
        } else {
            $errors = $DB->error;
            WebApp::moveBack("<!> 메뉴 순서를 변경하지 못했습니다.\n코드: $errors[code]\n에러: $errors[message]\n문장: $errors[sqltext]");
        }
	break;
}

?>