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

//if(!ereg('^[a-z]{1}[0-9a-z]{4,9}$',$id)) {
//2009-03-19 현민 숫자조합만도 가능
if(!ereg('^[0-9a-z]{3,10}$',$id)) {
    $ret = array(
        'Code' => '98',
        'Message' => '영문 소문자나 숫자로 3자리 이상 10자리 이하로 입력하여주십시오.!!'
    );
} else {


    $except_id = array(
        'guest','admin','kt','file','host','hosts','list','podo','asdf','search','master','tweb',
        'email','mail','ns','mx','find','book','bookmart','podoweb','test','drbum','jsseo','cis','iadmin','sadmin');

    $DB = &WebApp::singleton('DB');
    $sql = "SELECT COUNT(*) FROM ".TAB_MEMBER." WHERE  num_oid = '"._OID."' and str_id='$id'";
    $count = $DB->sqlFetchOne($sql);

    header('Content-Encoding: cp949');
    if ($count || in_array($id,$except_id)) {
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
}
echo $JSON->encode($ret);
?>