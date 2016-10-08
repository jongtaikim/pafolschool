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

$mou_name = "news";

$DB = &WebApp::singleton('DB');
$tpl = &WebApp::singleton('Display');
$conf_main =  WebApp::getThemeConf($mou_name);
$conf =  WebApp::getThemeConf(_LAYOUT_R.'_'.$mou_name);
$conf[title] = "새로운 게시물";
include $_SERVER["DOCUMENT_ROOT"].'/module/lib.php';

$tpl->assign($conf);
$tpl->assign($conf_main);


$template = "/theme_lib/".$mou_name."/".$theme."/attach.".$mou_name."_no.htm";

$code_main = array("com");

for($ii=0; $ii<count($code_main); $ii++) {


$listnum = $conf['listnum'];
if(!$listnum) $listnum = 8;

$len = $conf['len'];
if(!$len) $len = 20;


$code = $code_main[$ii];

			$sql = "SELECT
				/*+ INDEX_DESC(".TAB_MAIN_BOARD." ".PK_TAB_MAIN_BOARD.") */
				ROWNUM as rnum,
				NUM_SERIAL,
				STR_TITLE,
				TO_CHAR(DT_DATE,'YYYY-MM-DD') DT_DATE,
				STR_THUMB
			FROM ".TAB_MAIN_BOARD."
			WHERE
				NUM_OID="._OID." AND
				STR_CODE='$code' AND
				ROWNUM <= $listnum";


	if($data = $DB->sqlFetchAll($sql)) {
		$URL = &WebApp::singleton('WebAppURL');
		$FH = &WebApp::singleton('FileHost','main','news.'.$code);
		$FH->set_code('main','news.'.$code);
		for($i=0,$cnt=count($data);$i<$cnt;$i++) {
			
			
			$data[$i]['link'] = $URL->setVar(array(
				'act'=>'board.read',
				'mcode'=>$data[$i]['num_mcode'],
				'id'=>$data[$i]['num_serial'])
			);
			
			


		$a = explode("-", $data[$i]['dt_date']);
			
		 $data[$i]['dt_date1'] = $a[0];
		 $data[$i]['dt_date2'] = $a[1];
		 $data[$i]['dt_date3'] = $a[2];

			// 썸네일
			if($use_thumb && $data[$i]['str_thumb']) {
				$data[$i]['thumb_url'] = $FH->get_thumb_url($data[$i]['str_thumb'],$conf['thumb_width']);
			}

	  $data[$i]['is_recent'] = date('U') - strtotime($data[$i]['dt_date']) < 241920;
      


	  // 글씨 길이 조절 하는 부분


		$data[$i]['str_title'] = Display::text_cut($data[$i]['str_title'],$len,".."); 
		
		}
	}

	$tpl->assign(array('LIST_'.$code=>$data));
   
	

	$tpl->define('NEWS.'.$code,$template);	


	$content = $tpl->fetch('NEWS.'.$code);
	}
	



echo $content;
echo "|||news";

?>