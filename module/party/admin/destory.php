<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 foldmethod=marker: */
/**
* ���ϸ�: module/party/admin/destroy.php
* �ۼ���: 2006-06-13
* �ۼ���: �̹���
* ��  ��: ���Ƹ� ����
*****************************************************************
* 
*/
include 'module/admin/__init__.php';

$DB = &WebApp::singleton('DB');
$FH = &WebApp::singleton('FileHost');
$FTP = &WebApp::singleton('FtpClient',WebApp::getConf('account'));

// ÷������ ����, TAB_MENU_RIGHTS ����, ���������� ����
$FH = &WebApp::singleton('FileHost');
$sql = "SELECT num_mcode,str_type FROM ".TAB_PARTY_MENU." WHERE num_oid=$_OID AND num_pcode=$pcode";
$data = $DB->sqlFetchAll($sql);
foreach($data as $row){
    $FH->delete_as_code('party',$pcode.'.'.$row['num_mcode']);

    $sql = "DELETE FROM ".TAB_MENU_RIGHT." WHERE num_oid=$_OID AND str_sect='party' AND str_code='".$pcode.".".$row['num_mcode']."'";
    $DB->query($sql);
    $DB->commit();

    if($row['str_type'] == 'doc') {
        $FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/doc/party.'.$pcode.'.'.$row['num_mcode'].'.msg');
    }
}

// �������� TABLE ����
$sql = "DELETE FROM ".TAB_PARTY_MAIN_BOARD." WHERE num_oid=$_OID AND num_pcode=$pcode";
$DB->query($sql);
$DB->commit();

// MENU Module DB ����
$sql = "DELETE FROM ".TAB_PARTY_BOARD." WHERE num_oid=$_OID AND num_pcode=$pcode";
$DB->query($sql);
$DB->commit();
$sql = "DELETE FROM ".TAB_PARTY_BOARD_CONFIG." WHERE num_oid=$_OID AND num_pcode=$pcode";
$DB->query($sql);
$DB->commit();
$sql = "DELETE FROM ".TAB_PARTY_BOARD_COMMENT." WHERE num_oid=$_OID AND num_pcode=$pcode";
$DB->query($sql);
$DB->commit();
$sql = "DELETE FROM ".TAB_PARTY_COUNCIL." WHERE num_oid=$_OID AND num_pcode=$pcode";
$DB->query($sql);
$DB->commit();
$sql = "DELETE FROM ".TAB_PARTY_COUNCIL_CONFIG." WHERE num_oid=$_OID AND num_pcode=$pcode";
$DB->query($sql);
$DB->commit();
$sql = "DELETE FROM ".TAB_PARTY_MENU." WHERE num_oid=$_OID AND num_pcode=$pcode";
$DB->query($sql);
$DB->commit();
//2009-04-14 ���� ����� ����
$sql = "DELETE FROM ".TAB_PARTY_MEMBER." WHERE num_oid=$_OID AND num_pcode=$pcode";
$DB->query($sql);
$DB->commit();
# ���Ƹ� ���� ����
$sql = "SELECT str_photo FROM ".TAB_PARTY." WHERE num_oid=$_OID AND num_pcode=$pcode";
if($photo_path = $DB->sqlFetchOne($sql)) $FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/files/party/'.$photo_path);

// conf���� ����
$FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/conf/party/'.$pcode.'.conf.php');

// �Ұ� ���� ����
$FH->delete_as_code('party',$pcode.'.intro');
$FTP->delete(_DOC_ROOT.'/hosts/'.HOST.'/files/party/'.$pcode.'.intro.msg');

$sql = "DELETE FROM ".TAB_PARTY." WHERE num_oid=$_OID AND num_pcode=$pcode";
$DB->query($sql);
$DB->commit();

WebApp::redirect('party.admin.list','�����Ǿ����ϴ�.');
?>