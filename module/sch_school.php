<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-01-30
* 작성자: 김종태
* 설  명: 몰라임마~!
*****************************************************************
* 
*/


$DB = &WebApp::singleton('DB');
switch (REQUEST_METHOD) {
case "GET":
break;
case "POST":

$sql = "select * from TAB_SCHOOL where str_organ like '%".$_POST[q]."%' ";

 $row = $DB -> sqlFetchAll($sql);
 $tpl->assign(array(
	'school_LIST'=>$row,
	'q'=>$_POST[q],
  ));
 break;
} 
$tpl->setLayout('admin');
$tpl->define('CONTENT', Display::getTemplate('sch_school.htm'));

?>