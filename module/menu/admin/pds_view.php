<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 작성일: 2008-01-30
* 작성자: 김종태
* 설  명: 몰라임마~!
*****************************************************************
* 
*/
$tpl = &WebApp::singleton('Display');
$DB = &WebApp::singleton('DB');

$sql = "select STR_REFILE as send_files from ".TAB_PDS." where num_oid = "._OID." and num_mcode = '".$param[mcode]."' ";
$data =$DB -> sqlFetch($sql);
echo $sql;
$tpl->assign($data);


$template = $param['template'];
$tpl->define('emails_W_',$template);
$content = $tpl->fetch('emails_W_');
echo $content ;

?>