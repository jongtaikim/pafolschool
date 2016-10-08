<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: module/calendar/view.php
* �ۼ���: 2006-05-23
* �ۼ���: �̹���
* ��  ��: �����������
*****************************************************************
* 
*/
if(!$date = $_REQUEST['date']) errorAlert('�߸��� ��û�Դϴ�.');

$year = substr($date,0,4);
$month = substr($date,4,2);
$day = substr($date,6,2);

$DB = &WebApp::singleton('DB');
$sql = "SELECT num_serial,num_date,str_title,num_hit,num_icon FROM ".TAB_CALENDAR." WHERE num_oid=$_OID AND num_date=$date";
$list = $DB->sqlFetchAll($sql);
if(!$id = $_REQUEST['id']) $id = $list[0]['num_serial'];

if($id) {
    $sql = "UPDATE ".TAB_CALENDAR." SET num_hit = num_hit + 1 WHERE num_oid=$_OID AND num_serial=$id";
    $DB->query($sql);
    $DB->commit();

    $sql = "SELECT * FROM ".TAB_CALENDAR." WHERE num_oid=$_OID AND num_serial=$id";
    $data = $DB->sqlFetch($sql);

    $FH = &WebApp::singleton('FileHost','main','calendar');
    $data['content'] = $FH->set_content($data['str_text']);

    $data['FILE_LIST'] = $FH->get_files_info($id);
    $data['total_size'] = array_pop($data['FILE_LIST']);
    $tpl->assign($data);
}

$tpl->setLayout('admin');
$tpl->define('CONTENT','html/calendar/skin/'.$skin.'/view.htm');
$tpl->assign(array(
    'date'  => $date,
    'id'    => $id,
    'year'  => $year,
    'month' => $month,
    'day'   => $day,
    'LIST'  => $list
));

function errorAlert($msg) {
    if($msg) WebApp::alert($msg);
    WebApp::closeWin();
}
?>