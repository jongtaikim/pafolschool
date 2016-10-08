<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: inc.file_ftp.conn.php
* 작성일: 2004-09-08
* 작성자: 이범민
* 설  명: 파일서버 접속 및 FILE_HOST 와 FILE_FTP_ROOT를 알아내기 위한 함수
			$conn_flage 를 false로 호출할경우 접속은 하지 않음
*****************************************************************
* 
*/
function file_ftp_conn($conn_flag=true) {
	if(!$GLOBALS['FILE_FTP_ROOT']) {
		if(!$s_num = WebApp::getConf("file_ftp_num")) $s_num = '01';
		$file_ftp_conf_section = "file".$s_num."_account";
		if(!$ftp_conf) $ftp_conf = @parse_ini_file("conf/ftp.conf.php",true);
		$file_ftp_conf = $ftp_conf[$file_ftp_conf_section];
		$GLOBALS['FILE_HOST'] = $file_ftp_conf['host'];
		$GLOBALS['FILE_FTP_USER'] = $file_ftp_conf['user'];
		$GLOBALS['FILE_FTP_PASS'] = $file_ftp_conf['pass'];
		$GLOBALS['FILE_FTP_ROOT'] = $file_ftp_conf['root_dir'];
	}
	if(!$GLOBALS['FILE_FTP'] && $conn_flag) {
		$GLOBALS['FILE_FTP'] = &WebApp::singleton("FtpClient");
		$GLOBALS['FILE_FTP']->connect($GLOBALS['FILE_HOST'],$GLOBALS['FILE_FTP_USER'],$GLOBALS['FILE_FTP_PASS']);
	}
}
?>