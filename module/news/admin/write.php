<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/news/admin/write.php
* 작성일: 2009-07-09
* 작성자: 김종태
* 설  명: 등록/수정
*****************************************************************

* 
*/

			
$DB = &WebApp::singleton('DB');
$FH = &WebApp::singleton('FileHost','main','news.'.$code);
$id = $_REQUEST['id'];
$flg = $_REQUEST['flg'];
$del=$_REQUEST['del'];



switch($REQUEST_METHOD) {
	
	case "GET":
			

		if($id) {
			$sql = "SELECT 
						STR_TITLE,
						STR_TEXT,
						DT_DATE,
						NUM_HIT,
						STR_THUMB,
						NUM_ORDER,
						STR_HONOR_NAME,
						STR_MEMO
						
					FROM ".TAB_MAIN_BOARD."
					WHERE
						NUM_OID=$_OID AND
						STR_CODE='$code' AND
						NUM_SERIAL=$id";
			

			$data = $DB->sqlFetch($sql);
			$data['id'] = $id;
			$data['content'] = $data['str_text'];

			$data['content'] = WebApp::ImgChaneDe($data['content'], $data['id']);
			
			$datas['content'] = $data['content'];
			$DB->updateQuery("TAB_MAIN_BOARD",$datas," num_oid = "._OID." and str_code = 'news'  and num_serial = '".$id."'");
			$DB->commit();	
		

			$data['content'] = $FH->set_content($data['content']);
			
			if($data['FILE_LIST'] = $FH->get_files_info($id)) $data['total_size'] = array_pop($data['FILE_LIST']);
	
			} else {
			
			if(!$data['dt_date']) $data['dt_date'] = date('Y-m-d');	
			
			if($data['num_order'] == "1") {
				$data['num_order_chk'] == " checked";
			}
			
			$data['num_hit'] = '0';

		}
		$data['title'] = $title;
		$data['code'] = $code;
		$data['dt_date'] = date("Y-m-d",$data['dt_date']);
		
		$data['str_title2'] = $data['str_title'];

				
		$DB->query($sql);
		$DB->commit();

		$tpl->assign($data);

	if(!$skin) {
		$skin = "write";
	}
	$tpl->define('CONTENT','html/news/admin/write.htm');



	break;
	case "POST":
		


		if(!$dt_date) $dt_date = date("Y-m-d");

		$content = str_replace("'","''",$content);

		include $_SERVER["DOCUMENT_ROOT"].'/module/bi.php';

		//$content = $FH->get_content($content);
		$content = WebApp::ImgChaneDe($content, $id);


		if(!$num_order) $num_order = 0;

		$dt_date = WebApp::mkday($_POST['dt_date']);

		if($id = $_POST['id']) {
			$serial = $id;
			// 수정
			$sql = 
			"UPDATE ".TAB_MAIN_BOARD." SET 
					STR_TITLE='".strip_tags($_POST['str_title'])."',
					STR_TEXT='".$content."',
				STR_HONOR_NAME='".$str_honor_name."',

				DT_DATE='".$dt_date."',
				NUM_HIT=".$_POST['num_hit'].",
				NUM_MCODE='".$_POST['num_mcode']."',
				NUM_ORDER='".$num_order."',
				STR_MEMO = '".$str_memo."'
				
			WHERE 
					NUM_OID=".$_OID." AND 
					STR_CODE='".$code."' AND 
					NUM_SERIAL=".$id;

		} else {
			// 등록
			
			$sql = "SELECT MAX(NUM_SERIAL) FROM ".TAB_MAIN_BOARD." WHERE NUM_OID=$_OID AND STR_CODE='$code'";
			$id = $DB->sqlFetchOne($sql) + 1;
			
			if(!$id) $id = 1;
			$serial = $id;

			$sql = 
				"INSERT INTO ".TAB_MAIN_BOARD." (".
					"NUM_MCODE,NUM_OID,STR_CODE,NUM_SERIAL,STR_TITLE,STR_TEXT,CHR_HTML,DT_DATE,NUM_HIT,NUM_ORDER , STR_MEMO, STR_HONOR_NAME ".	
				") VALUES (
			'$num_mcode',
			".
					$_OID.",".
					"'".$code."',".
					$id.",".
					"'".strip_tags($_POST['str_title'])."',".
					"'".$content."',".
					

					"'Y',
					'".$dt_date."',".

					$_POST['num_hit'].
					",".$num_order.",".
					"'".$str_memo."','".
					$str_honor_name."' )";
	    		
	
		}
		


	
		if($DB->query($sql)) {
			$DB->commit();



			// {{{ 업로드 파일 처리
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
			
			// }}}

			// 캐쉬삭제
			$FTP = &WebApp::singleton("FtpClient",WebApp::getConf("account"));
			$FTP->delete(_DOC_ROOT.'/'.$cache_file);
			$FTP->delete(_DOC_ROOT.'/'.$cache_file2);
			$FTP->close();

			
			
		WebApp::redirect($URL->setVar(array('act'=>'/news.admin.list','mcode'=>$mcode,'code'=>$code)));


		} else {


			$FH->rm_tmp_files($_POST['timestamp']);
			$FH->close();

			WebApp::raiseError('DB Insert Failed');
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