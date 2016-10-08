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


	$tpl = &WebApp::singleton('Display');
	$conf_main =  WebApp::getThemeConf('poll');
	$conf =  WebApp::getThemeConf(_LAYOUT_R.'_poll');
	$tpl->assign($conf);
	$tpl->assign($conf_main);

	//2008-04-17 종태 라이브러리를 위해서


	$template = $param['template'];

	$tpl->define("POLL_".$sect,$template);

    $DB = &WebApp::singleton('DB');
    $sql = 'SELECT * FROM '.TAB_POLL_MAIN.' '.
            'WHERE '.
                'num_oid='._OID.' AND '.
                'str_sect=\''.$sect.'\' AND '.
				'str_type=\'poll\' AND '.
                'dt_start_date<='.mktime().'  '.
                //'dt_finish_date>=SYSDATE AND '.
                'limit 0,1';

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
    
	$content = $tpl->fetch("POLL_".$sect);


echo $content;
?>