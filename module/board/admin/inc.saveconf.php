<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: 
* 작성일:
* 작성자:
* 설  명:
*****************************************************************
* 
*/

$data = $DB->sqlFetch("SELECT * FROM $CONFIG_TABLE WHERE num_oid=$_OID AND num_mcode=$mcode");
$data['chr_comment'] = ($_POST['chr_comment'] ? "On" : "Off");
@cb_format_config($data);

$tpl->define('CONF','html/board/admin/config.conf.tpl');
$tpl->assign($data);

$_board_config_content = $tpl->fetch('CONF');

$_board_config = tempnam('tmp','board_config_');
$fp = fopen($_board_config,'w');
fwrite($fp,$_board_config_content);
fclose($fp);

$_board_caption = tempnam('tmp','board_caption_');
$fp = fopen($_board_caption,'w');
fwrite($fp,$str_caption);
fclose($fp);

$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
$FTP->put($_board_config,_DOC_ROOT."/hosts/$HOST/conf/board/${mcode}.conf.php");
if($str_caption) {
	$FTP->put($_board_caption,_DOC_ROOT."/hosts/$HOST/contents/${mcode}.board.caption.htm");
} else {
	$FTP->delete(_DOC_ROOT."/hosts/$HOST/contents/${mcode}.board.caption.htm");
}

unlink($_board_config);
unlink($_board_caption);

// {{{ Functions
function cb_format_config(&$arr) {
	if ($arr['chr_listtype'] == 'G') {
		$arr['listtype'] = 'icon';
	} else {
		$arr['listtype'] = 'list';
	}
}
// }}}
?>
