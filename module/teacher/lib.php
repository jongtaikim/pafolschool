<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-11-12
* 작성자: 김종태
* 설  명: lib.php 표준 파일
*****************************************************************
* 
*/
$mcode = $param['code'];  //<wa:모듈 code="{mcode}"> wa테그에서 변수 넣은값 $mcode

$mou_name = "teacher"; //모듈이름 지정
$DB = &WebApp::singleton("DB");
$URL = &WebApp::singleton('WebAppURL');
$tpl = &WebApp::singleton('Display');
$conf_main =  WebApp::getConf($mou_name);
$conf =  WebApp::getConf(_LAYOUT_R.'_'.$mou_name);

include $_SERVER["DOCUMENT_ROOT"].'/module/lib.php'; //디자인툴 세션처리용 파일

$tpl->assign($conf);
$tpl->assign($conf_main);

$template = "/theme_lib/".$mou_name."/".$theme."/attach.".$mou_name."_no.htm"; //세션으로 받은 테마값으로 html 가져오기 

/*...... 이곳에 디비 select나 여러 가지 작업을 한후 .... */

if(!$conf['listnum']) $listnum= "5"; else  $listnum = $conf['listnum'];

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
$tpl->assign(array('LIST'=>$data));


$tpl->define('TEACHER_',$template);
$content = $tpl->fetch('TEACHER_');
echo $content;
echo "|||$mou_name"; //ajax통신으로 innerHTML을 해줄 레이어 타겟 아이디 보내기

?>