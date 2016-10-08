<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* 파일명: edit.php
* 작성일: 2005-03-31
* 작성자: 이범민
* 설  명: 
*****************************************************************
* 
*/
$mcode = $_REQUEST['mcode'];

$DB = &WebApp::singleton('DB');
$FH = &WebApp::singleton('FileHost','menu_top',$mcode);


switch($REQUEST_METHOD) {
	case "GET":




$qmenu_cache_file = '/hosts/'.HOST.'/inc.qmenu.htm';
$str_qmenu_body = file_get_contents(_DOC_ROOT.$qmenu_cache_file);

$tpl->assign(array(
	'str_qmenu_body'=>$FH->set_content($str_qmenu_body),
	'mcode'=>$mcode,
	'layout'=>$layout,

	));



		$tpl->setLayout('admin');	
		$tpl->define('CONTENT','html/attach/admin/qmenu.htm');

	break;
	case "POST":
		
$cache_file = '/hosts/'.HOST.'/inc.qmenu.htm';

$str_qmenu_body = str_replace("<p>&nbsp;</p>","",$str_qmenu_body);
$str_qmenu_body = str_replace("'","''",$str_qmenu_body);
$str_qmenu_body = WebApp::ImgChaneDe($str_qmenu_body);


/*$sql = "

update TAB_CSS set  
str_qmenu_body='$str_qmenu_body'
where 
NUM_OID = $_OID  AND num_serial = "._CSS." AND  str_layout = '$layout'
";

$DB->query($sql);
$DB->commit();*/

$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
$FTP->delete(_DOC_ROOT.$cache_file);
$FTP->put_string($FH->set_content($str_qmenu_body), _DOC_ROOT.$cache_file);



WebApp::moveBack('저장되었습니다.');

	break;
}
?>
