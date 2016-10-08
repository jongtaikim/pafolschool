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
						STR_TEXT1,
						STR_TEXT2,
						STR_TEXT3,
						STR_TEXT4,
						STR_TEXT5,
						STR_TEXT6,
						STR_TEXT7,
						STR_TEXT8,
						STR_TEXT9,
						STR_TEXT10,
						TO_CHAR(dt_date,'YYYY-MM-DD') dt_date,
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
			$data['content'] = $data['str_text1'].$data['str_text2'].$data['str_text3'].$data['str_text4'].$data['str_text5'].$data['str_text6'].$data['str_text7'].$data['str_text8'].$data['str_text9'].$data['str_text10'];
			
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
		
		$data['str_title2'] = $data['str_title'];

				
		$DB->query($sql);
		$DB->commit();

		$tpl->assign($data);


	$tpl->define('CONTENT','html/news/skin/'.$skin.'/write.htm');



	break;
	case "POST":
		



		$content = str_replace("'","''",$content);

		include $_SERVER["DOCUMENT_ROOT"].'/module/bi.php';

		//$content = $FH->get_content($content);
		


	


		if(!$num_order) $num_order = 0;

		if(!$_POST['dt_date'])$_POST['dt_date'] = date("Y-m-d");
		if(!$_POST['num_hit'])$_POST['num_hit'] = 0;

    if($id = $_POST['id']) {
			$serial = $id;
			$content = WebApp::ImgChaneDe($content, $id);
				list($str_text1,$str_text2,$str_text3,$str_text4,$str_text5,$str_text6,$str_text7,$str_text8,$str_text9,$str_text10) = content_split($content);
			// 수정
			$sql = 
			"UPDATE ".TAB_MAIN_BOARD." SET 
					STR_TITLE='".strip_tags($_POST['str_title'])."',
					STR_TEXT1='".$str_text1."',
					STR_TEXT2='".$str_text2."',
					STR_TEXT3='".$str_text3."',
				STR_TEXT4='".$str_text4."',
				STR_TEXT5='".$str_text5."',
				STR_TEXT6='".$str_text6."',
				STR_TEXT7='".$str_text7."',
				STR_TEXT8='".$str_text8."',
				STR_TEXT9='".$str_text9."',
				STR_TEXT10='".$str_text10."',
				STR_HONOR_NAME='".$str_honor_name."',

				DT_DATE=TO_DATE('".$_POST['dt_date']."','YYYY-MM-DD'),
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
			
			list($str_text1,$str_text2,$str_text3,$str_text4,$str_text5,$str_text6,$str_text7,$str_text8,$str_text9,$str_text10) = content_split($content);
			$content = WebApp::ImgChaneDe($content, $id);
			$sql = 
				"INSERT INTO ".TAB_MAIN_BOARD." (".
					"NUM_MCODE,NUM_OID,STR_CODE,NUM_SERIAL,STR_TITLE,STR_TEXT1,STR_TEXT2,STR_TEXT3,STR_TEXT4,STR_TEXT5,STR_TEXT6,STR_TEXT7,STR_TEXT8,STR_TEXT9,STR_TEXT10,CHR_HTML,DT_DATE,NUM_HIT,NUM_ORDER , STR_MEMO, STR_HONOR_NAME ".	
				") VALUES (
			'$num_mcode',
			".
					$_OID.",".
					"'".$code."',".
					$id.",".
					"'".strip_tags($_POST['str_title'])."',".
					"'".$str_text1."',".
					"'".$str_text2."',".
					"'".$str_text3."',".
					"'".$str_text4."',".
					"'".$str_text5."',".
					"'".$str_text6."',".
					"'".$str_text7."',".
					"'".$str_text8."',".
					"'".$str_text9."',".
					"'".$str_text10."',".

					"'Y',".
					"TO_DATE('".$_POST['dt_date']."','YYYY-MM-DD'),".
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

			
			
		WebApp::redirect($URL->setVar(array('act'=>'/news.list','mcode'=>$mcode)));


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