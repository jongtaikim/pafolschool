<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: member/search_school.php
* 작성일: 2006-03-15
* 작성자: 이범민
* 설  명: 학교명 검색
*****************************************************************
* 
*/
$form = $_REQUEST['form'];
$el_school = $_REQUEST['el_school'];
$el_serial = $_REQUEST['el_serial'];
$el_focus = $_REQUEST['el_focus'];

$DB = &WebApp::singleton('DB');
if ($REQUEST_METHOD == 'POST') {
    $search = $_POST['search'];
    $sql = "SELECT * FROM TAB_SCHOOL_LIST WHERE str_name LIKE '%$search%'";
    $data = $DB->sqlFetchAll($sql);
}

$tpl->setLayout('admin');
$tpl->define('CONTENT','html/member/search_school.htm');
$tpl->assign(array(
    'form'  => $form,
    'el_school' => $el_school,
    'el_serial' => $el_serial,
    'el_focus'  => $el_focus,
    'search'    => $search,
    'LIST'      => $data
));
?>