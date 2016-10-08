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
		} while($_mcode = substr($_mcode,0,-2));
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

            $FTP = &WebApp::singleton("FtpClient",WebApp::getConf('account'));
            $FTP->delete($_DOC_ROOT.'/hosts/'.$HOST.'/menu.xml');
            if(strlen($mcode)>2) $FTP->delete($_DOC_ROOT.'/hosts/'.$HOST.'/menu/'.substr($mcode,0,-2).'.htm');
            $FTP->delete($_DOC_ROOT.'/hosts/'.$HOST.'/menu/'.$mcode.'.htm');
            $FTP->close();

            echo "<script>
            try {
                top.frames['menu'].tree.getSelected().parentNode.reload();
                top.frames['menu'].setSelected('$parent');
            } catch(e) {
                //  nothing special
            }
            </script>";

			list($module_name,$module_type) = explode('#',$str_type);
			include 'module/'.$module_name.'/admin/__add.php';
			$DB->commit();
			WebApp::redirect($URL->setVar(array('act'=>'menu.option','mcode'=>$mcode)));
		} else {
			WebApp::raiseError(_('Can Not Add Menu'));
		}
	break;
}
?>
