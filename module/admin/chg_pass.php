<?
/**********************************************
* : module/admin/chg_pass.php
*   :  ¬ß 
*   : 2003-10-15
* : 
***********************************************/

switch ($REQUEST_METHOD) {
	case "GET":
		$tpl->setLayout('admin');
		$tpl->define('CONTENT', Display::getTemplate('admin/chg_pass.htm'));
		break;
	case "POST":
		$newpass = $_REQUEST['newpass'];
		$DB = &WebApp::singleton('DB','podoweb');
		$sql = "UPDATE TAB_ORGAN SET str_password='".$newpass."' WHERE num_oid=".$_OID;
		$DB->query($sql);
		if (!$DB->error) {
			$DB->commit();
			WebApp::redirect($URL->getvar(),_('Modified'));
		} else {
			WebApp::raiseError(_('Modify Failed'));
		}
		break;
}
?>
