<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: lib.gettext.php
* �ۼ���: 2005-01-05
* �ۼ���: ��ģ����
* ��  ��: �ٱ������� ���̺귯��
*****************************************************************
* 
*/

if (!function_exists('gettext')) {
	function _($str) {
		return (@array_key_exists($str,$_ENV['locale'])) ? $_ENV['locale'][$str] : $str;
	}

	function gettext($str) {
		return _($str);
	}

	function bindtextdomain ($domain, $path) {
		$_ENV['locale.path'] = $path;
		textdomain($domain);
	}

	function textdomain($domain) {
        static $locale;
        $_lang = WebApp::getConf('site.language');
		$_ENV['locale.file'] = $domain.'.php';
		include_once($_ENV['locale.path'].'/'.$_lang.'/LC_MESSAGES/'.$_ENV['locale.file']);
		$_ENV['locale'] = $locale;
	}
}

$LANGUAGE = WebApp::getConf('site.language');
putenv("LANGUAGE=$LANGUAGE");
setlocale(LC_ALL, $LANGUAGE);
setlocale(LC_MESSAGES, $LANGUAGE);
bindtextdomain('messages','locale');
textdomain('messages');

?>
