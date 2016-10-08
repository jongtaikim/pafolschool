<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2009-08-24
* 작성자: 김종태
* 설   명: 호스트 환경설정
*****************************************************************
* 
*/

$DB = &WebApp::singleton('DB');

switch ($REQUEST_METHOD) {
	case "GET":
		$sql = "SELECT * FROM ".TAB_ORGAN." WHERE NUM_OID=$_OID";
		$data = $DB->sqlFetch($sql);
        unset($data['str_password']);
		
		$emain = explode("@",$data[str_master_email]);
		$data[str_master_email1] = $emain[0];
		$data[str_master_email2] = $emain[1];

		$data['s_title'] = $_S_TITLE;
		$tpl->setLayout('no4');	

		//2009-03-04 member skin 작업 by ahmin001
		$skinlist = array();
		foreach (glob('html/member/skin/*',GLOB_ONLYDIR) as $str_skin) {
            $str_skin = array_pop(explode('/',$str_skin));
            $skininfo = @parse_ini_file("html/member/skin/{$str_skin}/skin.conf.php");
            $skinlist[] = array(
                'str_skin' => $str_skin,
                'skin_name' => $skininfo['name']
            );
		}

		$tpl->assign(array(
			'member_skin' => $skinlist
		));

		$tpl->define('CONTENT', Display::getTemplate('admin/common.htm'));
		$tpl->assign($data);
		
		break;
	case "POST":
		
		$str_master_email = $str_master_email1."@".$str_master_email2;	

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


	  
	  

        $sql = "
UPDATE ".TAB_ORGAN." SET
    str_organ='$str_organ',
    str_title='$str_title',
    str_ceo_name='$str_ceo_name',
    str_ceo_email='$str_ceo_email',
	str_sa_number = '$str_sa_number', 
    str_phone='$str_phone',
    str_fax='$str_fax',
    chr_zip='$chr_zip',
    str_addr1='$str_addr1',
    str_addr2='$str_addr2',
    str_master_name='$str_master_name',
    str_master_phone='$str_master_phone',
    str_master_mobile='$str_master_mobile',
    str_master_email='$str_master_email',
	str_bi='$str_bi',
	str_g_code='$str_g_code'
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
			$FTP->put_string($tpl->fetch('COPYRIGHT'),_DOC_ROOT.'/hosts/'.HOST.'/copyright.htm');

			$INI = &WebApp::singleton("IniFile");
			$INI->load('hosts/'.HOST.'/conf/global.conf.php');
			$INI->setVar("email",$data['str_master_email']);
			$INI->setVar("oname",$data['str_organ']);
            $INI->setVar("ophone",$data['str_phone']);
            $INI->setVar("obranch",$data['str_branch_name']);
            $INI->setVar("naver_api",$naver_api);
            $INI->setVar("title",addslashes($data['str_title']));
			$FTP->put_string($INI->_combine(),_DOC_ROOT.'/hosts/'.HOST.'/conf/global.conf.php');
    	// }}}
	unset($_SESSION[_ORGAN]);
		WebApp::moveBack(_("Modified"));
}
?>
