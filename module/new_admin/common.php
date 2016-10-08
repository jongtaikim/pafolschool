<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* : admin/common.php
* :  <comfuture@debugs.co.kr>
* : 2004-01-14
*   :  б 
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');

switch ($REQUEST_METHOD) {
	case "GET":
		$sql = "SELECT * FROM ".TAB_ORGAN." WHERE NUM_OID=$_OID";
		$data = $DB->sqlFetch($sql);
        unset($data['str_password']);

		$tpl->setLayout('admin');
		$tpl->define('CONTENT', Display::getTemplate('new_admin/common.htm'));
        $FORM = &WebApp::singleton('Form','basicinfo');
        $FORM->setValues($data);
		break;
	case "POST":
        $str_organ = $_POST['str_organ'];
        $str_title = $_POST['str_title'];
        $str_password = $_POST['str_password'];
        $str_ceo_name = $_POST['str_ceo_name'];
        $str_ceo_email = $_POST['str_ceo_email'];
        $str_phone = $_POST['str_phone'];//.'-'.$_POST['str_phone2'].'-'.$_POST['str_phone3'];
        $str_fax = $_POST['str_fax'];//.'-'.$_POST['str_fax2'].'-'.$_POST['str_fax3'];
        $chr_zip = $_POST['chr_zip'];
        $str_addr1 = $_POST['str_addr1'];
        $str_addr2 = $_POST['str_addr2'];
        $str_master_name = $_POST['str_master_name'];
        $str_master_phone = $_POST['str_master_phone'];
        $str_master_mobile = $_POST['str_master_mobile'];
        $str_master_email = $_POST['str_master_email'];

        $sql = "
UPDATE ".TAB_ORGAN." SET
    str_organ='$str_organ',
    str_title='$str_title',
    str_ceo_name='$str_ceo_name',
    str_ceo_email='$str_ceo_email',
    str_phone='$str_phone',
    str_fax='$str_fax',
    chr_zip='$chr_zip',
    str_addr1='$str_addr1',
    str_addr2='$str_addr2',
    str_master_name='$str_master_name',
    str_master_phone='$str_master_phone',
    str_master_mobile='$str_master_mobile',
    str_master_email='$str_master_email'
    ".($str_password ? ", str_password='$str_password'" : '')."
WHERE num_oid=$_OID";
		if (!$DB->query($sql)) {
			WebApp::raiseError('DB 저장중 오류가 발생했습니다.');
		}
		$DB->commit();

		// {{{ Dump Files

			$data = $DB->sqlFetch("SELECT * FROM ".TAB_ORGAN." WHERE NUM_OID=$_OID");

			$tpl->define('COPYRIGHT',Display::getTemplate('tpl.copyright.htm'));
			$tpl->assign($data);

			$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
            $FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/menu.xml');
			$FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/cate.xml');

			$FTP->put_string($tpl->fetch('COPYRIGHT'),_DOC_ROOT.'/hosts/'.HOST.'/copyright.htm');

			$INI = &WebApp::singleton("IniFile");
			$INI->load('hosts/'.HOST.'/conf/global.conf.php');
			$INI->setVar("email",$data['str_master_email']);
			$INI->setVar("oname",$data['str_organ']);
            $INI->setVar("ophone",$data['str_phone']);
            $INI->setVar("obranch",$data['str_branch_name']);
            $INI->setVar("title",addslashes($data['str_title']));
			$FTP->put_string($INI->_combine(),_DOC_ROOT.'/hosts/'.HOST.'/conf/global.conf.php');
    	// }}}

		WebApp::moveBack(_("Modified"));
}
?>
