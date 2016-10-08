<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/menu/sub.php
* 작성일: 2005-04-01
* 작성자: 이범민
* 설  명: 서브메뉴출력
*****************************************************************
* 
*/
function cb_submenu_format(&$arr) {
	global $URL;
	list($module_name,$module_type) = explode('#',$arr['str_type']);
	$mdata = WebApp::get($module_name,array('key'=>'menu','mcode'=>$arr['num_mcode']));
	$arr['str_link'] = is_array($mdata['menu_url']) ? $URL->setVar($mdata['menu_url']) : $mdata['menu_url'];
	$arr['str_target'] = $mdata['menu_target'];
}

$mcode = $_REQUEST['mcode'] ? $_REQUEST['mcode'] : $_REQUEST['code'];
if (!$mcode && $p = $_REQUEST['p']) list(,$mcode) = explode('.',$p);
if (!$mcode || !is_numeric($mcode)) return;

$DB = &WebApp::singleton('DB');
switch (strlen($mcode)) {
	case 4: case 6:	case 8:
		//==-- 서브의 서브메뉴가 있는지 검사 --==//
		$DB = &WebApp::singleton('DB');
		$subnum = $DB->sqlFetchOne("SELECT COUNT(*) FROM ".TAB_MENU." WHERE NUM_OID="._OID." AND NUM_MCODE LIKE '$mcode%'");
		if($subnum > 1) {
			$_mcode = $mcode;
		} else {
			$_mcode = substr($mcode,0,-2);
		}
		break;
	case 2: default:
		$_mcode = $mcode;
		break;
}

$cache_file = 'hosts/'.HOST.'/menu/'.$_mcode.'.htm';
if(!is_file($cache_file)) {
	$len = strlen($_mcode) + 2;
	$current_menu = $DB->sqlFetchOne("SELECT STR_TITLE FROM TAB_MENU WHERE NUM_OID="._OID." AND NUM_MCODE=$_mcode");
	$sql = "SELECT /*+ INDEX(".TAB_MENU." ".PK_TAB_MENU.") */ * FROM TAB_MENU WHERE NUM_OID="._OID." AND NUM_MCODE LIKE '$_mcode%' AND LENGTH(NUM_MCODE)=$len";
	if($data = $DB->sqlFetchAll($sql)) array_walk($data,'cb_submenu_format');

	$tpl = &WebApp::singleton('Display');
	$tpl->define("SUBMENU_AREA",$param['template']);
	$tpl->assign(array(
		"SUBMENU"=>$data,
		'current_menu'=>$current_menu
	));
	$content = $tpl->fetch("SUBMENU_AREA");

	$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
	if(!$FTP->chdir(_DOC_ROOT.'/hosts/'.HOST.'/menu')) {
		$FTP->chdir(_DOC_ROOT.'/hosts/'.HOST);
		$FTP->mkdir('menu');
	}
	$FTP->put_string($content,_DOC_ROOT.'/'.$cache_file);
	$FTP->close();
} else {
	$fp = fopen($cache_file,'r');
	$content = @fread($fp,filesize($cache_file));
	fclose($fp);
}
echo $content;
?>
