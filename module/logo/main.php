<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2008-01-30
* �ۼ���: ������
* ��  ��: �ΰ������ �Žñ�
*****************************************************************
* 
*/
$DB = &WebApp::singleton('DB');
//����� �ƴҰ��� ���켼��
$tpl = &WebApp::singleton('Display');
$conf_main =  WebApp::getThemeConf('logo');
$conf =  WebApp::getThemeConf(_LAYOUT_R.'_logo');
$tpl->assign($conf);
$tpl->assign($conf_main);
//����� �ƴҰ��� ���켼��

$mcode = $param['mcode'];

//2008-04-17 ���� ���̺귯���� ���ؼ�

$template = "/theme_lib/logo/noimg/attach.logo_no.htm";

if(_MCODE){
	$sql = "select str_title from tab_menu where num_oid = '"._OID."' and num_mcode = '".substr(_MCODE,0,2)."'";
	$menu_title= $DB -> sqlFetchOne($sql);
	$tpl->assign(array('menu_title'=>$menu_title));
}


$tpl->define('LOGO__',$template);
	
$content = $tpl->fetch('LOGO__');

echo $content;

?>