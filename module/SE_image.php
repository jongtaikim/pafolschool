<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-01-30
* 작성자: 김종태
* 설  명: 몰라임마~!
*****************************************************************
* 
*/
header("Content-Type: text/plain; charset=euc-kr");

$FH = &WebApp::singleton('FileHost','menu','11');
$FH->set_oid($_OID);
$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));

switch ($REQUEST_METHOD) {
	case "GET":

		//if($data['FILE_LIST'] = $FH->get_files_info("img")) $data['total_size'] = array_pop($data['FILE_LIST']);
		
		//$source_dir = $FH->root_dir.'/tmp_upload/'.$_COOKIE['PHPSESSID'].'/'.$timestamp;
		$source_dir = $FH->root_dir.'/tmp_upload/'.$_COOKIE['PHPSESSID'];
		$a=0;
		if($updir_list = $FTP->getList($source_dir)) {
			foreach($updir_list as $dir1) {
				foreach($FTP->getList($source_dir."/".$dir1[filename]) as $file1){
					$fileurl = "http://".$FH->host.'/tmp_upload/'.$_COOKIE['PHPSESSID']."/".$dir1[filename]."/".urlencode($file1[filename]);
					$upfile_list[$a][url] = $fileurl;

					list($w,$h) = getImageSize($fileurl);
					if($w > 650) $w=650;
					$upfile_list[$a][w] = $w;
					$upfile_list[$a][h] = $h;

					$upfile_list[$a][filenm] = basename($fileurl);
					$a++;
				}
			}
		}

		$tpl->setLayout('admin');
		$tpl->define("CONTENT", Display::getTemplate("SE_image.htm"));
		$tpl->assign(array(
			'upfile_list'=>$upfile_list,
		));

	break;
	case "POST":

		WebApp::moveBack();

	break;
}
?>