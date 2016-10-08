<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: lib.gettext.php
* 작성일: 2005-01-05
* 작성자: 거친마루
* 설  명: 다국어지원 라이브러리
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
