<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/party/news/admin/write.php
* 작성일: 2006-05-17
* 작성자: 이범민
* 설  명: 등록/수정
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');
$FH = &WebApp::singleton('FileHost','party',$pcode.'.news');
$id = $_REQUEST['id'];

switch($REQUEST_METHOD) {
	case "GET":
		$tpl->setLayout('admin');
		$tpl->define('CONTENT','html/party/news/admin/write.htm');

		if($id) {
			$sql = "SELECT 
						str_title,
						str_text1,
						str_text2,
						str_text3,
						TO_CHAR(dt_date,'YYYY-MM-DD') dt_date,
						num_hit
					FROM ".TAB_PARTY_MAIN_BOARD."
					WHERE
						num_oid=$_OID AND
						num_pcode=$pcode AND
						num_serial=$id";
			$data = $DB->sqlFetch($sql);
			$data['id'] = $id;
			$data['content'] = $data['str_text1'].$data['str_text2'].$data['str_text3'];
			$data['content'] = $FH->set_content($data['content']);
			
			if($data['FILE_LIST'] = $FH->get_files_info($id)) $data['total_size'] = array_pop($data['FILE_LIST']);
		} else {
			$data['dt_date'] = date('Y-m-d');
			$data['num_hit'] = '0';
		}
		$data['title'] = $title;
		$data['code'] = $code;

		$tpl->assign($data);
	break;
	case "POST":
		$content = $FH->get_content($_POST['content']);
		list($str_text1,$str_text2,$str_text3) = content_split($content);

		if($id = $_POST['id']) {
			// 수정
			$sql = 
				"UPDATE ".TAB_PARTY_MAIN_BOARD." SET ".
					"str_title='".strip_tags($_POST['str_title'])."',".
					"str_text1='".$str_text1."',".
					"str_text2='".$str_text2."',".
					"str_text3='".$str_text3."',".
					"dt_date=TO_DATE('".$_POST['dt_date']."','YYYY-MM-DD'),".
					"num_hit=".$_POST['num_hit'].
				" WHERE ".
					"num_oid=".$_OID." AND ".
					"num_pcode=".$pcode." AND ".
					"num_serial=".$id;
		} else {
			// 등록
			$sql = "SELECT MAX(NUM_SERIAL) FROM ".TAB_PARTY_MAIN_BOARD." WHERE num_oid=$_OID AND num_pcode=$pcode";
			$id = $DB->sqlFetchOne($sql) + 1;
			$sql = 
				"INSERT INTO ".TAB_PARTY_MAIN_BOARD." (".
					"num_oid,num_pcode,num_serial,str_title,str_text1,str_text2,str_text3,chr_html,dt_date,num_hit".	
				") VALUES (".
					$_OID.",".
					$pcode.",".
					$id.",".
					"'".strip_tags($_POST['str_title'])."',".
					"'".$str_text1."',".
					"'".$str_text2."',".
					"'".$str_text3."',".
					"'Y',".
					"TO_DATE('".$_POST['dt_date']."','YYYY-MM-DD'),".
					$_POST['num_hit'].
				")";
		}
		
		if($DB->query($sql)) {
			$DB->commit();

			// {{{ 업로드 파일 처리
			$num_file = ($upfiles = trim($_POST['upfiles'])) ? count(explode("\n",$upfiles)) : 0;
			if ($num_file) {
				$FH->upload_process($_POST['timestamp'],$id);
				$FH->rm_tmp_dir($_POST['timestamp']);
			}
			$FH->find_upload($content);
			$FH->rm_tmp_dir();
			$FH->close();
			// }}}

			WebApp::redirect($URL->setVar(array('act'=>'.list','id'=>'')));
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