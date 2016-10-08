<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: module/admin/main/comptabs.php
* �ۼ���: 2005-07-26
* �ۼ���: �̹���
* ��  ��: ���������������� ���
*****************************************************************
* 
*/
if(!$_SESSION['ADMIN']) return;
$selected_url = $param['selected_url'] ? $param['selected_url'] : REQUEST_URI;
$selected_url = ereg_replace('^/','',$selected_url);
$confs = array_merge(
			array(array('title'=>'* ����ȭ�� ǥ�⼳��','admin_url'=>'admin.main.compose','available'=>true)),
			Display::getMainConf()
		);
foreach($confs as $conf) {
	if($conf['available'] && $conf['admin_url']) {
		if(strpos($selected_url,$conf['admin_url']) !== false) $conf['class'] = 'class="active"';
		$data[] = $conf;
	}
}

$tpl = WebApp::singleton('Display');
$tpl->define('COMPONENT_TAB','html/admin/main/comptabs.htm');
$tpl->assign('COMPONENT_TABS',$data);
$tpl->print_('COMPONENT_TAB');
return;
?>