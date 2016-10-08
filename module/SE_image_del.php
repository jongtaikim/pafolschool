<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-01-30
* 작성자: 김종태
* 설  명: 몰라임마~!
*****************************************************************
* 
*/
$FH = &WebApp::singleton('FileHost','menu','11');
$FH->set_oid($_OID);
$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));

switch ($REQUEST_METHOD) {
	case "GET":
		$file1 = explode("/",$furl);
		$fileurl = $FH->root_dir.'/tmp_upload/'.$_COOKIE['PHPSESSID']."/".$file1[5]."/".$file1[6];
		$FTP->delete($fileurl);
		WebApp::moveBack();
	break;
	case "POST":
		$file1 = explode("/",$furl);
		$fileurl = $FH->root_dir.'/tmp_upload/'.$_COOKIE['PHPSESSID']."/".$file1[5]."/".$file1[6];
		if($FTP->delete($fileurl)){
			echo"Y";
		}
	break;
}
?>