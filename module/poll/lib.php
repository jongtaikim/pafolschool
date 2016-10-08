<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/poll/main.php
* 작성일: 2005-03-24
* 작성자: 이범민
* 설  명: 홈페이지 메인에 설문조사 표출
*****************************************************************
* 
*/
require_once dirname(__FILE__).'/__init__.php';


$mou_name = "poll";

$tpl = &WebApp::singleton('Display');
$conf_main =  WebApp::getThemeConf($mou_name);
$conf =  WebApp::getThemeConf(_LAYOUT_R.'_'.$mou_name);

include $_SERVER["DOCUMENT_ROOT"].'/module/lib.php';

$tpl->assign($conf);
$tpl->assign($conf_main);

	$template = "/theme_lib/".$mou_name."/".$theme."/attach.".$mou_name."_no.htm";



    $DB = &WebApp::singleton('DB');
    $sql = 'SELECT '.
                '/*+ INDEX_DESC ('.TAB_POLL_MAIN.' '.IDX_TAB_POLL_TERM.') */ '.
                'str_sect,num_serial,str_title as poll_title,chr_result,chr_check,'.
                'TO_CHAR(dt_start_date,\'YYYYMMDD\') dt_start_date,'.
                'TO_CHAR(dt_finish_date,\'YYYYMMDD\') dt_finish_date '.
            'FROM '.TAB_POLL_MAIN.' '.
            'WHERE '.
                'num_oid='._OID.' AND '.
                'str_sect=\''.$sect.'\' AND '.
                'dt_start_date<=SYSDATE AND '.
                //'dt_finish_date>=SYSDATE AND '.
                'ROWNUM=1';
    $today = date('Ymd');
    if($data = $DB->sqlFetch($sql)) {
        $data['is_poll'] = true;
        $data['sect'] = &$data['str_sect'];
        $data['id'] = &$data['num_serial'];
        $data['is_finish'] = ($today > $data['dt_finish_date']);
        $data['is_progress'] = !$data['is_finish'];
        $data['is_result'] = ($data['chr_result'] == 'e') || ($data['chr_result'] == 'i' && $data['is_finish']);
        $sql = "SELECT num_serial,str_contents FROM ".TAB_POLL_CONTENTS."
                WHERE num_oid="._OID." AND num_main=".$data['num_serial'];
        $data['LIST'] = $DB->sqlFetchAll($sql);
        $tpl->assign($data);
    }
  

	$tpl->define("POLL_".$sect,$template);
    $content = $tpl->fetch("POLL_".$sect);
	
echo iconv("euc-kr","utf-8",$content);
echo "|||poll";
?>