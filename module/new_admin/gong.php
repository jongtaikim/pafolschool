<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: main.php
* 작성일: 2005-03-23
* 작성자: 이범민
* 설  명: 홈페이지 메인에서 출력
*****************************************************************
* 
*/



$conf = Display::getMainConf('news_'.$code);
if(!$listnum = $conf['listnum']) $listnum = 5;


$use_thumb = $conf['use_thumb'];


	$DB = &WebApp::singleton('DB');



	$sql = "SELECT
				
				ROWNUM as rnum,
				NUM_SERIAL,
				STR_TITLE,
				TO_CHAR(DT_DATE,'YYYY-MM-DD') DT_DATE,
				STR_THUMB
			FROM ".TAB_MAIN_BOARD."
			WHERE
				NUM_OID=1 AND
				STR_CODE='com' AND
				ROWNUM <= 6 order by num_serial desc	";


	
	
	
	
	if($data = $DB->sqlFetchAll($sql)) {
		$URL = &WebApp::singleton('WebAppURL');
		$FH = &WebApp::singleton('FileHost','main','news.'.$code);
		$FH->set_code('main','news.'.$code);
		for($i=0,$cnt=count($data);$i<$cnt;$i++) {
			
			
			$data[$i]['link'] = $URL->setVar(array(
				'act'=>'news.list',
				'code'=>$code,
				'mcode'=>$mcode,
				'id'=>$data[$i]['num_serial'])
			);
			
			


$a = explode("-", $data[$i]['dt_date']);
	
 $data[$i]['dt_date2'] = $a[1]."/".$a[2]; 




			// 썸네일
			if($use_thumb && $data[$i]['str_thumb']) {
				$data[$i]['thumb_url'] = $FH->get_thumb_url($data[$i]['str_thumb'],$conf['thumb_width']);
			}
      $data[$i]['is_recent'] = date('U') - strtotime($data[$i]['dt_date']) < 241920;
      // 글씨 길이 조절 하는 부분
	  $data[$i]['str_title2'] = Display::text_cut($data[$i]['str_title'],26,".."); 
	  $data[$i]['str_title3'] = Display::text_cut($data[$i]['str_title'],20,".."); //장성테마 IJ3 용 메인 공지사항 글자수 적용
	  $data[$i]['str_title4'] = Display::text_cut($data[$i]['str_title'],30,".."); //테마 IJ2 용 메인 공지사항 글자수 적용
	  $data[$i]['str_title5'] = Display::text_cut($data[$i]['str_title'],48,".."); //테마 IJ2 용 메인 공지사항 글자수 적용
	  	  $data[$i]['str_title6'] = Display::text_cut($data[$i]['str_title'],80,".."); //테마 IJ2 용 메인 공지사항 글자수 적용
		}
	}
	
	$tpl->setLayout('admin');
	$tpl->define("CONTENT", WebApp::getTemplate("new_admin/gong.htm"));
	$tpl->assign('LIST',$data);

	




?>