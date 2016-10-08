<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: member/check_masterid.php
* 작성일: 2006-03-08
* 작성자: 이범민
* 설  명: tab_member에서 중복여부 체크
*****************************************************************
* 
*/
$JSON = WebApp::singleton('JSON');
$id = $_REQUEST['id'];




    $except_id = array(
        'guest','admin','kt','file','host','hosts','list','podo','asdf','search','master','tweb',
        'email','mail','ns','mx','find','book','bookmart','podoweb','test','drbum','jsseo','cis');

    $DB = &WebApp::singleton('DB');
    $sql = "SELECT COUNT(*) FROM ".TAB_MEMBER." WHERE  num_oid = '"._OID."' and str_id='$id'";
    $count = $DB->sqlFetchOne($sql);
	
	//2009-02-23 예응 동영상관리 유저
    $sql = "SELECT COUNT(*) FROM ".TAB_WMV_USER." WHERE  num_oid = '"._OID."' and str_id='$id'";
    $count2 = $DB->sqlFetchOne($sql);

    header('Content-Encoding: cp949');
    if ($count2 ||$count || in_array($id,$except_id)) {
        $ret = array(
            'Code' => '99',
            'Message' => 'ID가 존재합니다'
        );
    } else {
        $ret = array(
            'Code' => '00',
            'Message' => '사용 가능합니다'
        );
    }

echo $JSON->encode($ret);
?>