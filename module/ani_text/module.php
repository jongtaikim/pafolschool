<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2008-11-12
* �ۼ���: ������
* ��  ��: main.php ǥ�� ����
*****************************************************************
* 
*/

$cache_file = _DOC_ROOT.'/hosts/'.HOST.'/'."inc.main.ani_text.htm";
if($del =="y") unlink($cache_file);
if(!is_file($cache_file) || date('Ymd H') > date('Ymd H',filemtime($cache_file))) {




$DB = &WebApp::singleton("DB"); //���Ŭ����
$URL = &WebApp::singleton('WebAppURL'); //URL Ŭ����
$tpl = &WebApp::singleton('Display'); //���ø����� Ŭ����
$mcode = $param['code'];  //<wa:��� code="{mcode}"> wa�ױ׿��� ���� ������ $mcode


	$sql = "select num_serial, str_text, num_view, str_url from TAB_ANI_TEXT where num_oid="._OID." and num_view='Y' order by num_step";
	$data = $DB -> sqlFetchAll($sql);

	$tpl->assign(array(
	'LIST'=>$data,

	));





$make = "y";
} else {
	$fp = fopen($cache_file,'r');
	$content = fread($fp,filesize($cache_file));
	fclose($fp);
}

?>