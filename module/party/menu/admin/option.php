<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/party/menu/admin/option.php
* 작성일: 2006-05-16
* 작성자: 이범민
* 설  명: 
*****************************************************************
* 
*/
 header('Content-Type: text/html; charset=EUC-KR');

$DB = &WebApp::singleton('DB');
$mcode = $_REQUEST['mcode'];

switch (REQUEST_METHOD) {
	case "GET":
		$env = array('showopt' => true);
		$data = $DB->sqlFetch("SELECT * FROM ".TAB_PARTY_MENU." WHERE num_oid=$_OID AND num_pcode=$pcode AND num_mcode=$mcode");
		list($module_name,$module_type) = explode('#',$data['str_type']);
        if(!$module_name) $module_name = $mcode;
		$ext_data = WebApp::get('party.'.$module_name,array('key'=>'menu','pcode'=>$pcode,'mcode'=>$mcode,'module_type'=>$module_type));
		if(is_array($ext_data['admin_url'])) $ext_data['admin_url'] = $URL->setVar($ext_data['admin_url']);

		
		$sql = "select str_skin,str_main_view from TAB_PARTY_BOARD_CONFIG where num_oid = $_OID and num_pcode = $pcode and num_mcode = $mcode";
		$board_s = $DB -> sqlFetch($sql);
		$tpl->assign($board_s);


		
		

		$tpl->setLayout('admin');
		$tpl->define('CONTENT', Display::getTemplate('party/menu/admin/option.htm'));
        $tpl->assign('TABS',&$ext_data['admin_tabs']);
		$tpl->assign($data);
		$tpl->assign($ext_data);
		$tpl->assign(array(
            'env'           => $env,
            'mcode'         => $mcode
        ));
		break;
/// {{{ 저장하는 부분
	case "POST":
		$what = $_POST['what'];
        $mcode = $_REQUEST['mcode'];

        $new_title = $_POST['str_title'];
        $num_view = $_POST['num_view'] ? 1 : 0;
        $menu_type = $DB->sqlFetchOne("SELECT str_type FROM ".TAB_PARTY_MENU." WHERE num_oid=$_OID AND num_pcode=$pcode AND num_mcode=$mcode");
        
		if($str_link_url) {
			$psql = ", str_link_url = '$str_link_url' ,str_target='$str_target'";
		}





        $sql = "UPDATE ".TAB_PARTY_MENU." SET str_title='$new_title',num_view=$num_view ,str_top_menu='$str_top_menu' $psql  WHERE num_oid=$_OID AND num_pcode=$pcode AND num_mcode=$mcode";
        if ($DB->query($sql)) {
            $DB->commit();

        $sql = "UPDATE ".TAB_PARTY_BOARD_CONFIG." SET str_title='$new_title',str_skin='$str_skin',str_main_view = '$str_main_view' WHERE num_oid=$_OID AND num_pcode=$pcode AND num_mcode=$mcode";

        if ($DB->query($sql)) {
		$DB->commit();
		}
        echo '<script>alert("변경되었습니다.");</script>';
 		echo "<script>parent.reloadMenu()</script>";
       
        } else {
        
		echo $sql;
            
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
