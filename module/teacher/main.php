<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-11-12
* 작성자: 김종태
* 설  명: main.php 표준 파일
*****************************************************************
* 
*/
$DB = &WebApp::singleton("DB"); //디비클래스
$URL = &WebApp::singleton('WebAppURL'); //URL 클래스
$tpl = &WebApp::singleton('Display'); //템플릿엔진 클래스
$mcode = $param['code'];  //<wa:모듈 code="{mcode}"> wa테그에서 변수 넣은값 $mcode

$mou_name = "teacher"; //모듈이름 지정
$conf_main =  WebApp::getThemeConf($mou_name);
$conf =  WebApp::getThemeConf(_LAYOUT_R.'_'.$mou_name); //해당모듈 디자인툴 환경설정값 불러오기
$tpl->assign($conf);
$tpl->assign($conf_main);

//2008-04-17 종태 라이브러리를 위해서

if($conf['skin']) $theme_name = $conf['skin']; 
elseif($conf_main['skin']) $theme_name = $conf_main['skin'];
else $theme_name = "simple"; //스킨이 없을경우 기본

$template = $param['template'];
if ($theme_name) $template = "/theme_lib/".$mou_name."/".$theme_name."/attach.".$mou_name."_no.htm"; //스킨값이 있을 경우 해당 폴더에서 html을 가져온다

$tpl->define('TEACHER_',$template);

/*...... 이곳에 디비 select나 여러 가지 작업을 한후 .... */
if(!$conf['listnum']) $listnum= "5"; else  $listnum = $conf['listnum'];
if(!$conf['img_w']) $img_w= "60"; else  $img_w = $conf['img_w'];
if(!$conf['img_h']) $img_h= "109"; else  $img_h = $conf['img_h'];
if(!$conf['col']) $col= "3"; else  $col = $conf['col'];

$sql = "
select a.* from (
         select ROWNUM as RNUM, b.* from (
			select 
				NUM_OID, STR_TACH_CODE, STR_NAME, STR_TACH_TYPE,STR_TACH_TITLE
			from TAB_TACH 
			where num_oid = "._OID."   
			and num_view = 1 
			order by STR_TACH_CODE asc
			)b)a
		where a.RNUM >  0 and a.RNUM <= $listnum
";

$data = $DB->sqlFetchAll($sql);

$tpl->assign(array(
'LIST'=>$data,
));

$content = $tpl->fetch("TEACHER_");
echo $content;

?>