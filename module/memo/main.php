<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-11-24
* 작성자: 장진수
* 설  명: main.php 쪽지관리
*****************************************************************
* 
*/
$DB = &WebApp::singleton("DB"); //디비클래스
$URL = &WebApp::singleton('WebAppURL'); //URL 클래스
$tpl = &WebApp::singleton('Display'); //템플릿엔진 클래스
$mcode = $param['code'];  //<wa:모듈 code="{mcode}"> wa테그에서 변수 넣은값 $mcode

$mou_name = "memo"; //모듈이름 지정
$conf_main =  WebApp::getThemeConf($mou_name);
$conf =  WebApp::getThemeConf(_LAYOUT_R.'_'.$mou_name); //해당모듈 디자인툴 환경설정값 불러오기
$tpl->assign($conf);
$tpl->assign($conf_main);

//2008-04-17 종태 라이브러리를 위해서
if($conf['skin']) $theme_name = $conf['skin']; 
elseif($conf_main['skin']) $theme_name = $conf_main['skin'];
else $theme_name = "simple"; //스킨이 없을경우 기본

$template = $param['template'];
if ($theme_name) $template = "/theme_lib/$mou_name/".$theme_name."/attach.".$mou_name."_no.htm"; //스킨값이 있을 경우 해당 폴더에서 html
/*...... 이곳에 디비 select나 여러 가지 작업을 한후 .... */

$sql = "
SELECT COUNT(*) 
 FROM TAB_MEMO 
 WHERE num_oid = "._OID." and str_to_id = '".$_SESSION[USERID]."'
  AND str_save='N' AND str_to_del = 'N'
";

$total_memo = $DB->sqlFetchOne($sql);
if(!$total_memo) $total_memo = 0;

$sql = "
SELECT COUNT(*) 
 FROM TAB_MEMO 
 WHERE num_oid = "._OID." AND str_to_id = '".$_SESSION[USERID]."' 
  AND str_reading_date IS NULL AND str_save='N' AND str_to_del = 'N'
";

$new_memo = $DB->sqlFetchOne($sql);
if(!$new_memo) $new_memo = 0;

$tpl->assign(array(
	'MEMO_LIST'=>$data,
	'total_memo'=>$total_memo,
	'new_memo'=>$new_memo
));

$tpl->define('MEMO__',$template);
$content = $tpl->fetch('MEMO__');
echo $content;

?>

