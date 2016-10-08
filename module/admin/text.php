<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* : admin/common.php
* :  <comfuture@debugs.co.kr>
* : 2004-01-14
*   :  흠....
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');

switch ($REQUEST_METHOD) {
	case "GET":
	

//2008-03-28 종태 안양서중 기능 막기
if(_THEME == "anyangseo"){
echo "<meta http-equiv='Refresh' Content=\"0; URL='/skin.select'\">";
exit;
}


$tpl->assign(array('s_title'=>$_S_TITLE));



if($f) {
$tpl->setLayout('admin');
}else{
$tpl->setLayout('menu2');
}

if(_THEME == "SH3") {
		$tpl->define('CONTENT', Display::getTemplate('admin/text_sh3.htm'));	
}elseif(_THEME == "SH4") {
		$tpl->define('CONTENT', Display::getTemplate('admin/text_sh4.htm'));	
}elseif(_THEME == "SH6") {
		$tpl->define('CONTENT', Display::getTemplate('admin/text_sh6.htm'));	
}else{
		$tpl->define('CONTENT', Display::getTemplate('admin/text.htm'));
}

        
		break;
	
	case "POST":

$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
		// {{{ Dump Files
			$INI = &WebApp::singleton("IniFile");
			$INI->load('hosts/'.HOST.'/conf/global.conf.php');
			$INI->setVar("s_title",$s_title);
			$FTP->put_string($INI->_combine(),_DOC_ROOT.'/hosts/'.HOST.'/conf/global.conf.php');
    	// }}}

		WebApp::moveBack();
}
?>
