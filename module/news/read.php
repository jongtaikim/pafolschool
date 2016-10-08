<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2009-07-09
* 작성자: 김종태
* 설   명: 고정게시판 읽기
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');


	$sql = "SELECT
				STR_TITLE,
				NUM_SERIAL,
						STR_TEXT, DT_DATE,
				NUM_HIT,
				STR_MAIN_VIEW,
				STR_THUMB,
				STR_HONOR_NAME,
				NUM_MCODE,
				STR_MEMO
			FROM ".TAB_MAIN_BOARD."
			WHERE NUM_OID=$_OID AND STR_CODE='$code' AND NUM_SERIAL=$id";
	
		if($data = $DB->sqlFetch($sql)) {

		

		$sql = "UPDATE ".TAB_MAIN_BOARD." SET NUM_HIT = NUM_HIT + 1 WHERE NUM_OID=$_OID AND STR_CODE='$code' AND NUM_SERIAL=$id";
		$DB->query($sql);
		$DB->commit();

		$data['id'] = $id;
		$data['num_hit']++;
  

		$FH = &WebApp::singleton('FileHost','main','news.'.$code);
		$FH->code='news.'.$code;
		$FH->sect='main';

		$data['content'] = $FH->set_content($data['str_text']);

			
		
		$fdata = $FH->get_files_info($id);
		$total_size = array_pop($fdata);
		$data['FILE_LIST'] = &$fdata;
		
	}

$tpl->setLayout('admin');
$data['str_title2'] = $data['str_title'];


$tpl->assign($data);

//글쓰기 권한
if($MEM_TYPE[0] == "t" || $_SESSION['ADMIN']){
 $tpl->assign(array('writable'=>"Y"));
}


$tpl->define("CONTENT",WebApp::getTemplate("news/skin/$skin/read.htm"));

?>