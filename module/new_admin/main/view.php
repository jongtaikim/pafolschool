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

$_OID2 = "111"; // lms 공지사항은 111로 때운다..ㅋㅋ

		
			
		$tpl->setLayout('admin');
		$tpl->define('CONTENT','html/new_admin/view.htm');

		if($id) {
			$sql = "SELECT 
						STR_TITLE,
						STR_TEXT1,
						STR_TEXT2,
						STR_TEXT3,
						TO_CHAR(DT_DATE,'YYYY-MM-DD') DT_DATE,
						NUM_HIT,
						STR_THUMB
						num_file
					FROM ".TAB_MAIN_BOARD."
					WHERE
						NUM_OID=$_OID2 AND
						STR_CODE='$code' AND
						NUM_SERIAL=$id";
			$data = $DB->sqlFetch($sql);
			$data['id'] = $id;
			$data['content'] = $data['str_text1'].$data['str_text2'].$data['str_text3'];
			$data['content'] = $FH->set_content($data['content']);
			
			if($data['FILE_LIST'] = $FH->get_files_info($id)) $data['total_size'] = array_pop($data['FILE_LIST']);
		} else {
			$data['dt_date2'] = date('Y-m-d');
			$data['num_hit'] = '0';
		}
		$data['title'] = $title;
		$data['code'] = $code;
		
		$data['str_title2'] = $data['str_title'];

	
	$DB->query("update ".TAB_MAIN_BOARD." set NUM_HIT = NUM_HIT+1 where NUM_OID=$_OID2 AND STR_CODE='$code' AND	NUM_SERIAL=$id");

	$DB->commit();

    $FH = &WebApp::singleton('FileHost','main','news.'.$code);
    $FH->code='news.'.$code;
    $FH->sect='main';

		$data['content'] = $FH->set_content($data['str_text1'].$data['str_text2'].$data['str_text3']);
		if($fdata = $FH->get_files_info($id)) {
			$total_size = array_pop($fdata);
			foreach($fdata as $frow) {
				if(eregi("(jpg|jpeg|png|gif|bmp)", $frow['str_ftype'])) {
					$preview[] = array(
						'str_upfile' => $frow['str_upfile'],
						'preview' => "<img src='".$frow['file_url']."?nocount=1' onload='if(this.width > 500) this.width=500;' border='0'>",
					);
				}
			}
			$data['FILE_LIST'] = &$fdata;
			if($preview) $data['PREVIEW_LIST'] = &$preview;
		}

		   // 겔러리 미리보기
	
		$FH = &WebApp::singleton('FileHost','menu',$mcode);
		$files = $FH->get_files_info($id);
		$total_size = array_pop($files);
		$tpl->assign("FILE",&$files);

        $content_front = '';
        foreach($files as $file) {
            if(!ereg('(jpe?g|gif|png)',$file['str_ftype'])) continue;
            $content_front .= '<div align="center" style="margin:5px 0px 10px 0px;"><a href="'.$file['file_url'].'?nocount=1'.'" target="_blank">'.
                              '<img src="'.$file['file_url'].'?nocount=1'.'" border="0" align="center" '.
                              'onload="if(this.width > 600) this.width = 600;" vspace="5"><br>['.$file['str_upfile'].']</a></div>';
        }
        $data['content'] = $content_front.$data['content'];



		$tpl->assign($data);

	
?>