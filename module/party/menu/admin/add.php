<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/party/menu/admin/add.php
* 작성일: 2006-05-16
* 작성자: 이범민
* 설  명: 
*****************************************************************
* 
*/
$DB = WebApp::singleton('DB');

switch(REQUEST_METHOD) {
	case "GET":
		$cnt = $DB->sqlFetchOne("SELECT COUNT(*) FROM ".TAB_PARTY_MENU." WHERE num_oid=$_OID AND num_pcode=$pcode");
        if ($cnt > 9) {
            WebApp::alert(_("Can Not Add Mainmenu more than 10"));
            WebApp::closeWin();
        }

        $tpl->setLayout('admin');
		$tpl->define('CONTENT',WebApp::getTemplate('party/menu/admin/add.htm'));
		$tpl->assign('MENU_TYPE',$VAR_MENUTYPE);
	break;
	case "POST":
		$menu_name = $_POST['str_title'];
		$mcode = newChild($pcode);
		$str_type = $_POST['str_type'];

		$sql = "
			INSERT INTO ".TAB_PARTY_MENU."
				(num_oid, num_pcode, num_mcode, num_step, str_title, str_type, num_view)
			VALUES
				($_OID, $pcode, $mcode, $mcode, '$menu_name', '$str_type', 1)
		";
		if ($DB->query($sql)) {
			list($module_name,$module_type) = explode('#',$str_type);
			include 'module/party/'.$module_name.'/admin/__add.php';
			$DB->commit();

            $menu_data = WebApp::get('party.'.$module_name,array('key'=>'menu','pcode'=>$pcode,'mcode'=>$mcode,'module_type'=>$module_type));
            if ($menu_data['default_rights']) {
                $mem_types = WebApp::get('member',array('key'=>'member_types'));
                foreach($mem_types as $mem_type => $_value) {
                    $sql = "INSERT INTO ".TAB_MENU_RIGHT." (num_oid,str_sect,str_code,str_group,str_right)".
                           "VALUES ($_OID,'party','".$pcode.".".$mcode."','$mem_type','".$menu_data['default_rights']."')";
                    if(!$DB->query($sql)) die($sql);
                }
                $DB->commit();
            }

            // 링크 저장
            $sql = "UPDATE ".TAB_PARTY_MENU." SET ".
                        "str_link='".(is_array($menu_data['menu_url']) ? $URL->getVar($menu_data['menu_url'], false) : $menu_data['menu_url'])."', ".
                        "str_target='".($menu_data['menu_target'] ? $menu_data['menu_target'] : '_self')."' ".
                    "WHERE num_oid=$_OID AND num_pcode=$pcode AND num_mcode=$mcode";
            $DB->query($sql);
            $DB->commit();

            echo "<script type='text/javascript'>
            try {
                parent.frames['padmin_menu'].reloadParent();
            } catch(e) {
                //  nothing special
            }
            </script>";
			WebApp::redirect($URL->setVar(array(
				'act' => '.option',
                'parent' => '',
				'mcode' => $mcode
			)));
		} else {
			WebApp::raiseError(_('Can not add menu'));
		}
	break;
}

function newChild($pcode) {
	$DB = &WebApp::singleton('DB');
	$sql = "SELECT MAX(num_mcode) FROM ".TAB_PARTY_MENU." WHERE num_oid="._OID." AND num_pcode=$pcode";
	$result = $DB->sqlFetchOne($sql);
	if (!$result) $mcode = 10;
	else $mcode = $result + 1;
	if ($mcode > 99) {
        $mcode = 9;
        do {
            $mcode++;
            $sql = "SELECT COUNT(*) FROM ".TAB_PARTY_MENU." WHERE num_oid="._OID." AND num_pcode=$pcode AND num_mcode=$mcode";
        } while($DB->sqlFetchOne($sql));
    }
	return $mcode;
}
?>
