

<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/admin/menu/settype.php
* 작성일: 2005-02-15
* 작성자: 이범민
* 설  명: 
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');
$_OID = WebApp::getConf('oid');
$mcode = $_REQUEST['mcode'];

$DB = WebApp::singleton('DB');

switch($REQUEST_METHOD) {
	case "GET":
        $data = $DB->sqlFetch("SELECT * FROM tab_menu WHERE num_oid=$_OID AND num_mcode=$mcode");
		list($module_name,$module_type) = explode('#',$data['str_type']);
        $ext_data = WebApp::get($module_name,array('key'=>'menu','mcode'=>$mcode,'module_type'=>$module_type));

		// {{{   
		$_mcode = $mcode;
		do {
			$_location[] = $DB->sqlFetchOne("SELECT str_title FROM ".TAB_MENU." WHERE num_oid=$_OID AND num_mcode=$_mcode");
		} while(strlen($_mcode = substr($_mcode,0,-2)) > 1);
		$_location[] = _('Main');
		$menu_location = implode(' > ',array_reverse($_location));
		// }}}
		$str_title = $_location[0];

		foreach ($VAR_MENUTYPE as $value=>$text) $_loop[] = array('value'=>$value,'text'=>$text);

        $tpl->setLayout('admin');
		$tpl->define('CONTENT',Display::getTemplate('menu/admin/settype.htm'));
		$tpl->assign(array(
				'mcode'=>$mcode,
				'menu_location'=>$menu_location,
				'str_title'=>$str_title
			));
        $tpl->assign('TABS',&$ext_data['admin_tabs']);
		$tpl->assign('MENU_TYPE',$VAR_MENUTYPE);
		$tpl->assign('MENU_TYPE2',$VAR_MENUTYPE2);
	break;
	
	
	case "POST":
		$menu_name = $_POST['str_title'];
		$str_type = $_POST['str_type'];

		$sql = "
				UPDATE tab_menu SET
					str_title='$str_title', str_type='$str_type'
				WHERE
					num_oid=$_OID AND num_mcode=$mcode";
					
		if ($DB->query($sql)) {

            deleteCacheFiles($mcode);

			list($module_name,$module_type) = explode('#',$str_type);
			include 'module/'.$module_name.'/admin/__add.php';
			$DB->commit();

            $menu_data = WebApp::get($module_name,array('key'=>'menu','mcode'=>$mcode,'module_type'=>$module_type));
            if ($menu_data['default_rights']) {
                $mem_types = WebApp::get('member',array('key'=>'member_types'));
                foreach($mem_types as $mem_type => $_value) {
                    $sql = "INSERT INTO ".TAB_MENU_RIGHT." (num_oid,str_sect,str_code,str_group,str_right)".
                           "VALUES ($_OID,'menu','$mcode','$mem_type','".$menu_data['default_rights']."')";
                    $DB->query($sql);
                }
                $DB->commit();
            }

			    if ($menu_data['default_group_rights']) {
              
				$sql = "select * from tab_group where num_oid = '$_OID' ";
				$row = $DB -> sqlFetchAll($sql);
				for($ii=0; $ii<count($row); $ii++) {
                   $sql = "INSERT INTO ".TAB_MENU_RIGHT." (num_oid,str_sect,str_code,str_group,str_right)".
                           "VALUES ($_OID,'menu','$mcode','".$row[$ii][str_group]."','".$menu_data['default_group_rights']."')";
                    $DB->query($sql);
					$DB->commit();				
				}
				
            }

            echo "<script>
            try {
                top.frames['menu'].reloadParent();
                top.frames['menu'].setSelected('$parent');
            } catch(e) {
                //  nothing special
            }
            </script>";

			WebApp::redirect($URL->setVar(array('act'=>'menu.admin.option','mcode'=>$mcode)));
		} else {
			WebApp::raiseError('메뉴를 추가 불가');
		}
	break;
}

?>
