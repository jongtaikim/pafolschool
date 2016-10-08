<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: module/board/admin/del.php
* �ۼ���: 2005-03-28
* �ۼ���: �̹���
* ��  ��: 
*****************************************************************
* 
*/
// ÷������ ����� ÷������ DB �ʱ�ȭ�ϱ�
require_once 'module/board/table_define.php';
$FH = &WebApp::singleton('FileHost','menu',$mcode);
$FH->delete_as_code('menu',$mcode);

// ����� ����
$sql = "SELECT STR_THUMB FROM $ARTICLE_TABLE WHERE NUM_OID=$_OID AND NUM_MCODE=$mcode AND STR_THUMB IS NOT NULL";
if($thumb_data = $DB->sqlFetchAll($sql)) {
	foreach($thumb_data as $row) $del_thumbs[] = $row['str_thumb'];
	$FH->del_thumb($del_thumbs);
}
$FH->close();

// �Խù� ���� �����
$DB->query("DELETE FROM $ARTICLE_TABLE WHERE num_oid=$_OID AND num_mcode=$mcode");
$DB->commit();

// �Խù� Comment ����
$DB->query("DELETE FROM $COMMENT_TABLE WHERE num_oid=$_OID and num_mcode=$mcode");
$DB->commit();

$listtype = $DB->sqlFetchOne("SELECT chr_listtype FROM $CONFIG_TABLE WHERE num_oid=$_OID AND num_mcode=$mcode");

// �Խ��� ���� �����
$DB->query("DELETE FROM $CONFIG_TABLE WHERE num_oid=$_OID AND num_mcode=$mcode");
$DB->commit();

// ��������, �ֱٰԽù� ����
$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));
$FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/conf/board/'.$mcode.'.conf.php');
$FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/inc.main.latestboard.'.$listtype.'.htm');





$name = "bbs_".$mcode;

$sql = "DELETE FROM ".TAB_ATTACH_CONFIG." WHERE num_oid=$_OID AND str_name='$name'";
$DB->query($sql);
$DB->commit();

$sql = "DELETE FROM ".TAB_ATTACH_PART." WHERE num_oid=$_OID AND str_name='$name'";
$DB->query($sql);
$DB->commit();


$FTP = WebApp::singleton('FtpClient',WebApp::getConf('account'));
//$FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/'.$attach_file[$ii]);

$attach_conf_file = 'hosts/'.HOST.'/conf/'._CSS.'.attach.conf.php';
$INI = &WebApp::singleton('IniFile',$attach_conf_file);
$INI->delSection($name);
$FTP->put_string($INI->_combine(),_DOC_ROOT.'/'.$attach_conf_file);

?>