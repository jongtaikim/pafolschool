<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: module/party/news/main.php
* 작성일: 2006-05-17
* 작성자: 이범민
* 설  명: 홈페이지 메인에서 출력
*****************************************************************
* 
*/
if(!$listnum = $conf['listnum']) $listnum = $param['listnum'];
if(!$listnum) $listnum = 5;

$DB = &WebApp::singleton('DB');
$sql = "SELECT
            /*+ INDEX_DESC(".TAB_PARTY_MAIN_BOARD." ".PK_TAB_PARTY_MAIN_BOARD.") */
            NUM_SERIAL,
            STR_TITLE,
            TO_CHAR(DT_DATE,'YYYY-MM-DD') DT_DATE
        FROM ".TAB_PARTY_MAIN_BOARD."
        WHERE
            num_oid="._OID." AND
            num_pcode=$pcode AND
            ROWNUM <= $listnum";
if($data = $DB->sqlFetchAll($sql)) {
    $URL = &WebApp::singleton('WebAppURL');
    $FH = &WebApp::singleton('FileHost');
    $FH->set_code('party',$pcode.'.news');
    for($i=0,$cnt=count($data);$i<$cnt;$i++) {
        $data[$i]['link'] = $URL->setVar(array(
            'act'=>'party.news.list',
            'pcode'=>$pcode,
            'id'=>$data[$i]['num_serial'])
        );
        $data[$i]['is_recent'] = date('U') - strtotime($data[$i]['dt_date']) < 241920;
    }
}

$tpl = &WebApp::singleton('Display');
$tpl->define('PARTY_NEWS',$param['template']);
$tpl->assign('LIST',$data);
$tpl->print_('PARTY_NEWS');
?>