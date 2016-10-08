<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: board/attachimage.php
* 작성일: 2004-07-09
* 작성자: 이범민
* 설  명: 컨텐츠에 포함될 이미지 저장
*****************************************************************
* 
*/
$HTTP_HOST = getenv("HTTP_HOST");

switch ($REQUEST_METHOD) {
	case "GET":
		break;
	case "POST":
		$oid = $_POST['oid'];
		$sect = $_POST['sect'];
		$code = $_POST['code'];
		$timestamp = $_POST['timestamp'];
		$phpsessid = $_POST['phpsessid'];

		if($attachfile = $_FILES['xfile0']['tmp_name']) {
			$DB = WebApp::singleton('DB');
			$fname = $_FILES['xfile0']['name'];
			$ftype = array_pop(explode(".",$fname));
			$fsize = filesize($attachfile);

			// {{{ FTP
			$FTP = WebApp::singleton("FtpClient");
			$ftp_host = WebApp::getConf("account.host");
			$ftp_user = WebApp::getConf("account.user");
			$ftp_pass = WebApp::getConf("account.pass");
			$FTP_ROOT = WebApp::getConf("account.root_dir");
			$FTP->connect($ftp_host,$ftp_user,$ftp_pass);

			$ym_dir = date('Ym',$timestamp);
			
			//NUM_MAIN 이 -1로 바뀌면서 pk 겹치면 안되기 때문에 NUM_MAIN<0 로 serial을 가져와야함
			$sql = "SELECT MAX(NUM_SERIAL) FROM ".TAB_FILES." WHERE NUM_OID=$oid AND STR_SECT='$sect' AND STR_CODE='$code' AND NUM_MAIN<0";
			$serial = $DB->sqlFetchOne($sql) + 1;
			$filename = $ym_dir."/".$code.".-1.".$serial.".".$timestamp.'.'.$ftype;
			$sql_insert = "
				INSERT INTO ".TAB_FILES." (
					NUM_OID,STR_SECT,STR_CODE,NUM_MAIN,NUM_SERIAL,STR_UPFILE,STR_REFILE,STR_FTYPE,NUM_SIZE
				) VALUES (
					$oid,'$sect','$code',-2,$serial,'$fname','$phpsessid.$timestamp','$ftype',$fsize
				)";
			
			$filepath = "hosts/$oid/$sect/".$filename;
			$remote_path = $FTP_ROOT."/".$filepath;
			if(!is_dir("hosts/$oid/$sect/$ym_dir")) {
				if(!is_dir("hosts/$oid/$sect")) {
					$FTP->chdir($FTP_ROOT."/hosts/$oid");
					$FTP->mkdir($sect);
				}
				$FTP->chdir($FTP_ROOT."/hosts/$oid/$sect");
				$FTP->mkdir($ym_dir);
			}
			$FTP->put($attachfile,$remote_path);
			$FTP->close();
			@unlink($attachfile);
			// }}}

			// {{{ Insert DB
			$DB->query($sql_insert);
			$DB->commit();
			// }}}
		}
		break;
}
/*
ob_start();
print_r($_FILES);
echo ($sql_insert);
$log = ob_get_contents();
ob_end_clean();

$fp = fopen('tmp_upload/sql_log.txt','w');
fwrite($fp,$log);
fclose($fp);
chmod('tmp_upload/sql_log.txt',0666);
//*/
?>
