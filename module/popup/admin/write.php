<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/popup/admin/add.php
* 작성일: 2009-08-14
* 작성자: 김종태
* 설  명: 팝업 등록/수정
*****************************************************************
* 
*/
$FH = &WebApp::singleton('FileHost','main',$code);
$FH->set_oid(_OID);

function mkday($date){
$a = explode("-",$date);
$mkt = mktime(00, 00, 00, $a[1],  $a[2], $a[0]);
return $mkt;
}


$FH = &WebApp::singleton('FileHost','main',$code);
require_once _DOC_ROOT.'/module/file.php';
list($num_disk, $num_upload_size, $db_num_size, $use_size, $maxfilesize) = OIDUploadFileSize();


		$tpl->assign(array(
			'num_disk'=>$num_disk,
			'num_upload_size'=>$num_upload_size,
			'db_num_size'=>$db_num_size,
			'use_size'=>$use_size,
			'maxfilesize'=>$maxfilesize,
			'str_category'=>$str_category,
		));

switch($REQUEST_METHOD) {
	case "GET":
		if($id = $_REQUEST['id']) {
			// 수정

			$DB = &WebApp::singleton('DB');
			$sql = "SELECT * FROM ".TAB_POPUP." WHERE NUM_OID=$_OID AND NUM_SERIAL=$id";
			
			if(!$data = $DB->sqlFetch($sql)) WebApp::raiseError('데이터가 없습니다.');
			
			$data['id'] = &$data['num_serial'];
			$data['content'] = $FH->set_content($data['str_text']);
			if($data['str_bg_refile']) $data['bg_url'] = 'hosts/'.$HOST.'/files/popup/'.$data['str_bg_refile'];
			
			if($data[dt_start_date]) $data[dt_start_date] = date("Y-m-d",$data[dt_start_date]);
			if($data[dt_end_date]) $data[dt_end_date] = date("Y-m-d",$data[dt_end_date]);

			// 첨부파일정보 
			$data['FILE_LIST'] = $FH->get_files_info($id);
			$data['total_size'] = array_pop($data['FILE_LIST']);
		}
		$tpl->setLayout('no3');


		$tpl->define('CONTENT','html/popup/admin/write.htm');
		$tpl->assign(array(
			'oid'=>$_OID,
			'code'=>$code,
			'ifr'=>$ifr,

		));
		if($data) $tpl->assign($data);
	break;
	case "POST":
		if($_POST['preview']) {
			// 
			if($bg_file = $_FILES['bg_file']['tmp_name']) @unlink($bg_file);
			$tpl->setLayout('blank');
			$tpl->define("CONTENT",WebApp::getTemplate("popup/skin/".$_POST['chr_skin']."/view.htm"));
			$tpl->assign(array(
				'preview'=>1,
				'str_title'=>$_POST['str_title'],
				'bg_url'=>$_POST['bg_file_local_url'],
				'content'=>$_POST['content']
			));
		} else {
			$DB = &WebApp::singleton('DB');
			
			$content = $_POST['content'];
			
			if(!$content) $content = '<p></p>';
			$content = WebApp::ImgChaneDe($content);
			$str_text = str_replace("'","''",$content);
			
			$num_left = max(0,$_POST['num_left']);
			$num_top = max(0,$_POST['num_top']);

			
				if(!$str_e) $str_e = 'N';
				if(!$str_m) $str_m = 'N';
				if(!$str_h) $str_h = 'N';

			if(!$id = $_POST['id']) {
				$sql =	"SELECT MAX(NUM_SERIAL) FROM ".TAB_POPUP." WHERE NUM_OID=$_OID and str_type = 'host'";
				$id = $DB->sqlFetchOne($sql) + 1;


			$serial = $id;
	
			$sql = "Insert into ".TAB_POPUP."
			   (NUM_OID, STR_TYPE, NUM_SERIAL, STR_TITLE, STR_TEXT, STR_SKIN, STR_OPEN, NUM_WIDTH, NUM_HEIGHT, NUM_LEFT, NUM_TOP, DT_DATE, 	DT_START_DATE, DT_END_DATE, STR_VIEW, STR_E, STR_M , STR_H,NUM_KILL,STR_URL)
			 Values
			   ("._OID.", 'host', ".$id.", '$str_title', '$str_text', '$str_skin', '".$_POST['str_open']."',  '".$_POST['num_width']."', '".$_POST['num_height']."', $num_left, $num_top, ".mktime().",'".mkday($dt_start_date)."','".mkday($dt_end_date)."', 'N', '$str_e', '$str_m' , '$str_h','$num_kill','$str_url')
			";
			
			//echo $sql;

	
			}else{
				
				$sql = "UPDATE ".TAB_POPUP." SET
							STR_TITLE='$str_title',
							STR_TEXT='$str_text',
							
							STR_SKIN='".$_POST['str_skin']."',
							STR_OPEN='".$_POST['str_open']."',
							NUM_WIDTH=".$_POST['num_width'].",
							NUM_HEIGHT=".$_POST['num_height'].",
							NUM_LEFT=".$num_left.",
							NUM_TOP=".$num_top.",
							
							str_e='".$str_e."',
							str_m='".$str_m."',
							str_h='".$str_h."',
							num_kill='".$num_kill."',
							str_url='".$str_url."',

							DT_START_DATE='".mkday($dt_start_date)."',
							DT_END_DATE='".mkday($dt_end_date)."'

						WHERE NUM_OID=$_OID AND NUM_SERIAL=$id";
						$serial = $id;
			}
			
	
			if($DB->query($sql)) {
				$DB->commit();
				

						//2009-07-01 종태 신규 업로드 프로세서
						$FH = &WebApp::singleton('FileHost');
						$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));

						$FTP->mkdir($FH->file_dir);
						$FTP->chmod($FH->file_dir,777);
						$FTP->mkdir($FH->file_dir."/".date("Ym")."/");
						$FTP->chmod($FH->file_dir."/".date("Ym")."/",777);


						
						for($ii=1; $ii<11; $ii++) {
							uploadFile($ii);
						}
			
				WebApp::redirect('/popup.admin.list');
			} else {

				WebApp::raiseError('DB Insert Failed');
			}
		}
	break;
}

function content_split($str) {
	$ret = array();
	while ($str) {
		$ret[] = substr($str,0,3999);
		$str = substr($str,3999);
	}
	return $ret;
}
?>