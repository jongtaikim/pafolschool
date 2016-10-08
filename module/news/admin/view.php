<?php
/**

* 작성일: 2007-06-21
* 작성자: 김종태
* 설  명: 보기
*****************************************************************
*/

$DB = &WebApp::singleton('DB');
$FH = &WebApp::singleton('FileHost','main','news.'.$code);
$id = $_REQUEST['id'];
$flg = $_REQUEST['flg'];
$del=$_REQUEST['del'];

$_OID2 = "1"; // 아이노크 공지사항은 1로 때린다

		
			
		$tpl->setLayout('admin');
		$tpl->define('CONTENT','html/admin/view.htm');

		if($id) {
			$sql = "SELECT 
						STR_TITLE,
						STR_TEXT1,
						STR_TEXT2,
						STR_TEXT3,
						TO_CHAR(DT_DATE,'YYYY-MM-DD') DT_DATE,
						NUM_HIT,
						STR_THUMB

					FROM ".TAB_MAIN_BOARD."
					WHERE
						NUM_OID=$_OID2 AND
						STR_CODE='$code' AND
						NUM_SERIAL=$id";
			$data = $DB->sqlFetch($sql);
			$data['id'] = $id;
			$data['content'] = $data['str_text1'].$data['str_text2'].$data['str_text3'];
			
			$s = explode("|",$data['content']);
			
			$data['num_price'] = $s[0];
			$data['str_h'] = $s[1];
			$data['str_tech'] = $s[2];
			$data['content'] = $s[3];
			


			
			$data['content'] = $FH->set_content($data['content']);
			
			if($data['FILE_LIST'] = $FH->get_files_info($id)) $data['total_size'] = array_pop($data['FILE_LIST']);
		} else {
			$data['dt_date2'] = date('Y-m-d');
			$data['num_hit'] = '0';
		}
		$data['title'] = $title;
		$data['code'] = $code;
		
		$data['str_title2'] = $data['str_title'];
	

		$tpl->assign($data);
	
?>