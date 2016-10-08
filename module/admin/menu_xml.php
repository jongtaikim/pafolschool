<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: module/admin/menu_xml.php
* �ۼ���: 2006-07-06
* �ۼ���: �̹���
* ��  ��: 
*****************************************************************
* 
*/
header('Content-type: text/xml');
header("Expires: ".gmdate("D, d M Y H:i:s")." GMT");
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");

$DB = WebApp::singleton('DB');
$sql = "SELECT str_layer FROM ".TAB_ATTACH_CONFIG." WHERE num_oid=$_OID AND str_layout='main' AND str_name='smenu'";
$layer = $DB->sqlFetchOne($sql);

$xml = '<'.'?xml version="1.0" encoding="euc-kr"?'.'>'.'
<tree>

	<tree icon="image/icon/madang.png" text="�޴�����" action="javascript:selectMenu();" src="menu.admin.xml"/>
    '.(($layer && $layer != 'NONE') ? '<tree icon="image/icon/madang.png" text="�߰��޴�" action="javascript:selectMenu(1);" src="menu.admin.xml?mcode=1"/>' : '').'
</tree>';
echo $xml;
exit;
?>