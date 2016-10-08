<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/menu/main.php
* 작성일: 2006-02-27
* 작성자: 이범민
* 설  명: 메인메뉴출력
*****************************************************************
* 
*/
function cb_mainmenu_format(&$arr) {
	global $URL;
	list($module_name,$module_type) = explode('#',$arr['str_type']);
	$mdata = WebApp::get($module_name,array('key'=>'menu','mcode'=>$arr['num_mcode']));
	$arr['str_link'] = is_array($mdata['menu_url']) ? $URL->setVar($mdata['menu_url']) : $mdata['menu_url'];
	$arr['str_target'] = $mdata['menu_target'];
	
}

$DB = &WebApp::singleton('DB');
$cache_file = 'hosts/'.HOST.'/menu/main.htm';
if(!is_file($cache_file)) {
	$sql = "SELECT /*+ INDEX(".TAB_MENU." ".PK_TAB_MENU.") */ * FROM TAB_MENU WHERE NUM_OID="._OID." AND LENGTH(NUM_MCODE)=2";
	if($data = $DB->sqlFetchAll($sql)) array_walk($data,'cb_mainmenu_format');

	$tpl = &WebApp::singleton('Display');
	$tpl->define("MAINMENU_AREA",$param['template']);
	$tpl->assign(array(
		'MAINMENU'  => $data,
		'cur_mcode' => $_REQUEST['mcode']
	));
	$content = $tpl->fetch("MAINMENU_AREA");

	$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
	if(!$FTP->chdir(_DOC_ROOT.'/hosts/'.HOST.'/menu')) {
		$FTP->chdir(_DOC_ROOT.'/hosts/'.HOST);
		$FTP->mkdir('menu');
	}
	$FTP->put_string($content,_DOC_ROOT.'/'.$cache_file);
	$FTP->close();
} else {
    $content = file_get_contents($cache_file);
}
echo $content;
?>
