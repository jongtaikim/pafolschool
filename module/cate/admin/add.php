<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: add.php
* 작성일: 2005-02-14
* 작성자: 이범민
* 설  명: 
*****************************************************************
* 
*/
$DB = WebApp::singleton('DB');

switch(REQUEST_METHOD) {
	case "GET":
		if (!$parent = $_REQUEST['parent']) {
			$cnt = $DB->sqlFetchOne("SELECT COUNT(*) FROM ".TAB_MENU." WHERE num_oid=$_OID AND LENGTH(num_mcode)=2");
			if ($cnt > 9) {
				WebApp::alert(_("Can Not Add Mainmenu more than 10"));
				WebApp::closeWin();
			}
		} else {
			$len = strlen($parent) + 2;
			$cnt = $DB->sqlFetchOne("SELECT COUNT(*) FROM ".TAB_MENU." WHERE num_oid=$_OID AND num_mcode LIKE '$parent%' AND LENGTH(num_mcode)=$len");
			if ($cnt > 14) {
				WebApp::alert(_("Can Not Add Submenu more than 15"));
				WebApp::closeWin();
			}
		}

		// {{{ 메뉴위치 로케이션바 만들기
		$_mcode = $parent;
		do {
			$_location[] = $DB->sqlFetchOne("SELECT str_title FROM ".TAB_MENU." WHERE num_oid=$_OID AND num_mcode=$_mcode");
		} while($_mcode = substr($_mcode,0,-2));
		$_location[] = _('Main');
		$menu_location = implode(' > ',array_reverse($_location));
		// }}}

		$tpl->define('CONTENT',WebApp::getTemplate('menu/admin/add.htm'));
		$tpl->assign('parent',$_REQUEST['parent']);
		$tpl->assign('menu_location',$menu_location);
		$tpl->assign('MENU_TYPE',$VAR_MENUTYPE);
	break;
	case "POST":
        $parent = $_REQUEST['parent'];
		$menu_name = $_POST['str_title'];
		$new_step = newStep($parent);
		$mcode = newChild($parent);
		$str_type = $_POST['str_type'];
		

		$sql = "
			INSERT INTO ".TAB_MENU."
				(num_oid, num_step, num_mcode, str_title, str_type)
			VALUES
				($_OID,$new_step,$mcode,'$menu_name','$str_type')
		";
		if ($DB->query($sql)) {
			list($module_name,$module_type) = explode('#',$str_type);
			include 'module/'.$module_name.'/admin/__add.php';
            $FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
            $FTP->delete($_DOC_ROOT.'/hosts/'.HOST.'/menu.xml');
            if(strlen($mcode)>2) $FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/menu/'.substr($mcode,0,-2).'.htm');
            $FTP->close();
			$DB->commit();
            echo "<script type='text/javascript'>
            try {
                top.frames['menu'].tree.getSelected().reload();
                top.frames['menu'].setSelected('{$parent}');
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

function newChild($mcode) {
	$DB = &WebApp::singleton('DB');
	$_OID = WebApp::getConf('oid');
	$len = strlen($mcode)+2;
	$sql = "SELECT MAX(num_mcode) FROM ".TAB_MENU." WHERE num_oid=$_OID AND num_mcode LIKE '$mcode%' AND LENGTH(num_mcode)=$len";
	$result = $DB->sqlFetchOne($sql);
	if (!$result) $max_mcode = 10;
	else $max_mcode = substr($DB->sqlFetchOne($sql),-2) + 1;
	if ($max_mcode > 99) WebApp::raiseError(_('Can not add menu'));
	return $mcode.sprintf("%02d",$max_mcode);
}

function newStep($mcode) {
	$DB = &WebApp::singleton('DB');
	$_OID = WebApp::getConf('oid');
	$len = strlen($mcode)+2;
	$sql = "SELECT MAX(num_step) FROM ".TAB_MENU." WHERE num_oid=$_OID AND num_mcode LIKE '$mcode%' AND LENGTH(num_mcode)=$len";
	return $DB->sqlFetchOne($sql) + 1;
}
?>
