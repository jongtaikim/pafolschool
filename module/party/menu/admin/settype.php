<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/party/menu/admin/settype.php
* 작성일: 2006-05-16
* 작성자: 이범민
* 설  명: 
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');
$mcode = $_REQUEST['mcode'];

$DB = WebApp::singleton('DB');

switch($REQUEST_METHOD) {
	case "GET":
        $data = $DB->sqlFetch("SELECT * FROM ".TAB_PARTY_MENU." WHERE num_oid=$_OID AND num_pcode=$pcode AND num_mcode=$mcode");
		list($module_name,$module_type) = explode('#',$data['str_type']);
        $ext_data = WebApp::get($module_name,array('key'=>'menu','pcode'=>$pcode,'mcode'=>$mcode,'module_type'=>$module_type));

		foreach ($VAR_MENUTYPE as $value=>$text) $_loop[] = array('value'=>$value,'text'=>$text);

        $tpl->setLayout('admin');
		$tpl->define('CONTENT',Display::getTemplate('party/menu/admin/settype.htm'));
		$tpl->assign(array(
				'mcode'=>$mcode,
				'str_title'=>$data['str_title']
			));
        $tpl->assign('TABS',&$ext_data['admin_tabs']);
		$tpl->assign('MENU_TYPE',$VAR_MENUTYPE);
	break;
	case "POST":
		$menu_name = $_POST['str_title'];
		$str_type = $_POST['str_type'];

		$sql = "
				UPDATE ".TAB_PARTY_MENU." SET
					str_title='$str_title', str_type='$str_type'
				WHERE
					num_oid=$_OID AND num_pcode=$pcode AND num_mcode=$mcode";
		if ($DB->query($sql)) {

			list($module_name,$module_type) = explode('#',$str_type);
			include 'module/party/'.$module_name.'/admin/__add.php';
			$DB->commit();

            $menu_data = WebApp::get($module_name,array('key'=>'menu','pcode'=>$pcode,'mcode'=>$mcode,'module_type'=>$module_type));
            if ($menu_data['default_rights']) {
                $mem_types = WebApp::get('party.member',array('key'=>'member_types'));
                foreach($mem_types as $mem_type => $_value) {
                    $sql = "INSERT INTO ".TAB_MENU_RIGHT." (num_oid,str_sect,str_code,str_group,str_right)".
                           "VALUES ($_OID,'party','".$pcode.".".$mcode."','$mem_type','".$menu_data['default_rights']."')";
                    if(!$DB->query($sql)) die($sql);
                }
                $DB->commit();
            }

            // 링크 저장
            $sql = "UPDATE ".TAB_PARTY_MENU." SET ".
                        "str_link='".$URL->getVar($menu_data['menu_url'], false)."', ".
                        "str_target='".($menu_data['menu_target'] ? $menu_data['menu_target'] : '_self')."' ".
                    "WHERE num_oid=$_OID AND num_pcode=$pcode AND num_mcode=$mcode";
            $DB->query($sql);
            $DB->commit();

            echo "<script>
            try {
                top.frames['padmin_menu'].reloadParent();
            } catch(e) {
                //  nothing special
            }
            </script>";

			WebApp::redirect($URL->setVar(array('act'=>'party.menu.admin.option','mcode'=>$mcode)));
		} else {
			WebApp::raiseError(_('Can Not Add Menu'));
		}
	break;
}
?>
