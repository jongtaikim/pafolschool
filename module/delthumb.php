<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: delthumb.php
* 작성일: 2005-03-29
* 작성자: 이범민
* 설  명: 
*****************************************************************
* 
*/
if(!$_POST['oid'] || !$_POST['sect'] || !$_POST['filename']) exit;
$filename = explode(',',$_POST['filename']);
$FTP  = &WebApp::singleton('FtpClient');
$account = WebApp::getConf('account');
if(!$FTP->connect($account['host'],$account['user'],$account['pass'])) exit;
foreach($filename as $file) {
	$_file = explode('.',$file);
	$ext = array_pop($_file);
	$thumb_file = implode('.',$_file).'.thumb.'.$ext;
	$FTP->delete($account['root_dir'].'/hosts/'$_POST['oid'].'/'.$_POST['sect'].'/'.$thumb_file);
}
$FTP->close();
echo '1';
?>