<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: board/attachfile.php
* 작성일: 2004-07-06
* 작성자: 이범민
* 설  명: 컴포넌트가 Post한 파일 처리
*****************************************************************
* 
*/
$phpsessid = $_REQUEST['phpsessid'];
$timestamp = $_REQUEST['timestamp'];
/*
ob_start();
print_r($_REQUEST);
$log = ob_get_contents();
ob_end_clean();

$fp = fopen('tmp_upload/upload.log','w');
fwrite($fp,$log);
fclose($fp);
*/
if(!$phpsessid || !$timestamp || !$_FILES) exit;
$ATT = &WebApp::singleton("AttachFile");
$tmp_pdir = "tmp_upload/$phpsessid";
if(!is_dir($tmp_pdir)) {
	mkdir($tmp_pdir);
	chmod($tmp_pdir,0777);
}
$tmp_dir = "$tmp_pdir/$timestamp";
if(!is_dir($tmp_dir)) {
	mkdir($tmp_dir);
	chmod($tmp_dir,0777);
}

$FTP = WebApp::singleton("FtpClient");
$ftp_host = WebApp::getConf("account.host");
$ftp_user = WebApp::getConf("account.user");
$ftp_pass = WebApp::getConf("account.pass");
$FTP_ROOT = WebApp::getConf("account.root_dir");
$FTP->connect($ftp_host,$ftp_user,$ftp_pass);

if($_FILES) {
	foreach($_FILES as $file) {
		if(!$file['tmp_name'] || !$file['size']) continue;
		$filename = $file['name'];
		if(strpos($filename,".") == 0) $filename = "_".$filename;
		if($FTP->put($file['tmp_name'],$FTP_ROOT.'/'.$tmp_dir.'/'.$filename)) $succeeded++;
		@unlink($file['tmp_name']);
	}
}
$FTP->close();

print "Succeeded: ".$succeeded;
?>