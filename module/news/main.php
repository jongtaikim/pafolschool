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

$DB = &WebApp::singleton('DB');
//모듈이 아닐경우는 지우세요
$tpl = &WebApp::singleton('Display');
$conf_main =  WebApp::getThemeConf('news');
$conf =  WebApp::getThemeConf(_LAYOUT_R.'_news');
$conf[title] = "뉴스레터";
$tpl->assign($conf);
$tpl->assign($conf_main);

//2008-04-17 종태 라이브러리를 위해서

if($conf['skin']) $theme_name = $conf['skin']; 
elseif($conf_main['skin']) $theme_name = $conf_main['skin'];
//else $theme_name = "simple"; //스킨이 없을경우 기본

	$template = $param['template'];
	$code_main = array("news");
	$listnum = $conf['listnum'];
	if(!$listnum) $listnum = 5;

	$len = $conf['len'];
	if(!$len) $len = 40;

	$code = 'news';

	$sql = " 

	select 
	 *
	from

	TAB_MAIN_BOARD

	where 
	num_oid = "._OID." and

	str_code = '$code'

	order by  num_serial desc limit 0,5

	";


	if($data = $DB->sqlFetchAll($sql)) {
		$URL = &WebApp::singleton('WebAppURL');
		$FH = &WebApp::singleton('FileHost','main','news.'.$code);
		$FH->set_code('main','news.'.$code);
		
		for($i=0,$cnt=count($data);$i<$cnt;$i++) {
			
			 $a = explode("-", $data[$i]['dt_date']);
				
			 $data[$i]['dt_date1'] = $a[0];
			 $data[$i]['dt_date2'] = $a[1];
			 $data[$i]['dt_date3'] = $a[2];

			// 썸네일
			if($use_thumb && $data[$i]['str_thumb']) {
				$data[$i]['thumb_url'] = $FH->get_thumb_url($data[$i]['str_thumb'],$conf['thumb_width']);
			}

	  $data[$i]['is_recent'] = date('U') - strtotime($data[$i]['dt_date']) < 241920;
	  $data[$i]['str_title'] = Display::text_cut($data[$i]['str_title'],$len,".."); 
		
		}
	}

	$tpl->assign(array('LIST_'.$code=>$data));
	$tpl->define('NEWS.'.$code,$template);

	$content = $tpl->fetch('NEWS.'.$code);
	

echo $content;
?>