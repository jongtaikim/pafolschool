<?
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* �ۼ���: 2008-09-02
* �ۼ���: ������
* ��  ��: ������ ajax�� ����
*****************************************************************
* 
*/
//����� �ƴҰ��� ���켼��
$tpl = &WebApp::singleton('Display');
$conf =  WebApp::getThemeConf($layout_r.'_'.$mou_name);

if(!$conf[bbs_title]) {
	$DB = &WebApp::singleton('DB'); 
	$sql = "select str_title from TAB_MENU where num_oid = '$_OID' and num_mcode = '".$conf[bbs_code]."'";
	$conf[bbs_title] = $DB -> sqlFetchOne($sql);
}
echo $conf[type]."|".$conf[bbs_code]."|".$conf[bbs_title];


?>